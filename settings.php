<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Trello boards settings file
 *
 * @package    local_trello
 * @copyright  2020 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_trello', get_string('pluginname', 'local_trello'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configtext('local_trello/apikey', get_string('apikey', 'local_trello'),
        get_string('apikey_help', 'local_trello'), '', PARAM_ALPHANUMEXT));

    $settings->add(new admin_setting_configtext('local_trello/apitoken', get_string('apitoken', 'local_trello'),
        get_string('apitoken_help', 'local_trello'), '', PARAM_ALPHANUMEXT));
}
