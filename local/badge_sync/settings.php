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

/**
 * Version details
 *
 * @package    local_badge_sync
 * @author     Stephan Lorbek
 * @copyright  2020 Stephan Lorbek
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Ensure the configurations for this site are set.
if ($hassiteconfig) {
    $settings = new admin_settingpage('local_badge_sync', get_string('pluginname', 'local_badge_sync'));
	$ADMIN->add('localplugins', $settings);
	 
	$default = $_SERVER['SERVER_NAME'];
    $name = 'local_badge_sync/target_moodle';
    $title = get_string('target_moodle', 'local_badge_sync');
    $description = get_string('target_moodle_description', 'local_badge_sync');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $settings->add($setting);
     
	$default = 'http://remote.server?json=';
    $name = 'local_badge_sync/target_post';
    $title = get_string('target_post', 'local_badge_sync');
    $description = get_string('target_post_description', 'local_badge_sync');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $settings->add($setting);
    
	$default = '';
    $name = 'local_badge_sync/token';
    $title = get_string('token', 'local_badge_sync');
    $description = get_string('token_description', 'local_badge_sync');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $settings->add($setting);
    
    $default = '';
    $name = 'local_badge_sync/payload';
    $title = get_string('json_payload', 'local_badge_sync');
    $description = get_string('json_payload_description', 'local_badge_sync');
    $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
    $settings->add($setting);
}
