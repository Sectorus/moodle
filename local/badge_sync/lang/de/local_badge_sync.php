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
 *
 * @package    local_badge_sync
 * @author     Stephan Lorbek
 * @copyright  2020 Stephan Lorbek
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Badge Sync';
$string['target_moodle'] = 'Ziel-Moodle';
$string['target_moodle_description'] = 'Moodle-Instanz von der die Daten geholt werden sollen.';
$string['target_post'] = 'Ziel-Server';
$string['target_post_description'] = 'Ziel-Server wohin die Badgeinformation per POST gesendet werden sollen.';
$string['token'] = 'Authentifizierungs Token';
$string['token_description'] = 'Dieser Token wird zur Authentifizierung der Moodle Webservices verwendet.';
$string['json_payload'] = 'JSON als Payload mitsenden';
$string['json_payload_description'] = 'Gibt an, ob der gesamte Informationssatz als Payload im JSON-Format mitgesendet werden soll.';
