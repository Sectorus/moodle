<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
defined('MOODLE_INTERNAL') || die();

use moodle_url;

/**
 * Email signup notification event observers.
 *
 * @package    local_badge_sync
 * @author     Stephan Lorbek
 * @copyright  2020 Stephan Lorbek
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_badge_sync_observer
{

    public static function request_handling($url, $payload)
    {
        if (!get_config('local_badge_sync', 'payload') && !array_key_exists('wstoken', $payload))
        {
            $payload = array();
        }
        $ch = curl_init($url);
        $postString = http_build_query($payload, '', '&');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response;
    }

    public static function badge_awarded(\core\event\badge_awarded $event)
    {
        global $DB;
        $token = get_config('local_badge_sync', 'token');
        $fields = ['id', 'courseid', 'expiredate', 'name'];
        $userid = $event->relateduserid;

        $payload = [
            'wsfunction' => 'core_badges_get_user_badges',
            'wstoken' => $token,
        ];

        $url = 'http://' . get_config('local_badge_sync', 'target_moodle') . '/webservice/rest/server.php?moodlewsrestformat=json&userid=' . $userid;
        $response = local_badge_sync_observer::request_handling($url, $payload);

        $json = json_decode($response, true);
        $result = array();

        $user_db = $DB->get_record('user', array(
            'id' => $userid
        ));

        for ($i = 0;$i < count($json['badges']);$i++)
        {
            $image_url = $json['badges'][$i]['badgeurl'];
            $image_url = str_replace("/webservice", "", $image_url);
            $badge = ['userid' => $userid, 'username' => $user_db->username, 'image_url' => $image_url, ];
            foreach ($json['badges'][$i] as $key => $value)
            {
                if (in_array($key, $fields, true))
                {
                    $badge[$key] = $value;
                }
            }
            $course_id = $json['badges'][$i]['courseid'];
            $course_name = null;
            if (!is_null($course_id))
            {
                $course_name = $DB->get_record('course', array(
                    'id' => $course_id
                ));
            }
            $badge['course'] = $course_name->fullname;
            array_push($result, $badge);
        }

        $payload = [
            'json' => $json,
        ];

        $t = trim(json_encode($result) , '[]');
        $url = get_config('local_badge_sync', 'target_post') . urlencode($t);
        $response = local_badge_sync_observer::request_handling($url, $payload);
        return true;
    }

    public static function course_created(\core\event\course_created $event)
    {
        $result = ['event' => "course_created", 'coursename' => $event->other['fullname'], 'course_id' => $event->courseid, ];
        $t = trim(json_encode($result) , '[]');

        $url = get_config('local_badge_sync', 'target_post') . urlencode($t);
        $response = local_badge_sync_observer::request_handling($url, $payload);
        return true;
    }

    public static function badge_created(\core\event\badge_created $event)
    {
        global $DB;
        $data = $DB->get_record('badge', array(
            'id' => $event->objectid,
        ));
        $badgeurl = moodle_url::make_webservice_pluginfile_url($event->contextid, 'badges', 'badgeimage', $event->objectid, '/', 'f1')
            ->out(false);
        $badgeurl = str_replace("/webservice", "", $badgeurl);

        $result = [
        'event' => "badge_created", 'id' => $event->objectid, 'name' => $data->name, 'courseid' => $data->courseid, 'expiredate' => $data->expiredate, 'badgeurl' => $badgeurl, ];
        $t = trim(json_encode($result) , '[]');

        $url = get_config('local_badge_sync', 'target_post') . urlencode($t);
        $response = local_badge_sync_observer::request_handling($url, $payload);
        return true;
    }
}
