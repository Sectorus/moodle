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
$string['target_moodle'] = 'Moodle';
$string['target_moodle_description'] = 'Moodle instance from where the data is fetched.';
$string['target_post'] = 'Target Server';
$string['target_post_description'] = 'Target server for the POST request.';
$string['token'] = 'Authentication Token';
$string['token_description'] = 'This token is used for authenticating the usage of Moodles core webservices.';
$string['json_payload'] = 'Transmit JSON as payload';
$string['json_payload_description'] = 'Determines if the whole data set should be send formatted in JSON.';
