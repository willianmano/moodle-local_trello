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
 * Trello boards creation.
 *
 * @package    local_trello
 * @copyright  2020 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_trello;

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

class observer {
    /**
     * Observer for \core\event\course_created event.
     *
     * @param \core\event\course_created $event
     *
     * @return void
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function course_created(\core\event\course_created $event) {
        $course = $event->get_record_snapshot('course', $event->objectid);

        $apikey = get_config('local_trello', 'apikey');
        $apitoken = get_config('local_trello', 'apitoken');

        $parameters = [
            'name' => $course->fullname,
            'defaultLists' => true,
            'key' => $apikey,
            'token' => $apitoken
        ];

        $trelloapiurl = sprintf('https://api.trello.com/1/boards?%s', utf8_encode(http_build_query(
            $parameters,
            '',
            '&'
        )));

        try {
            $ch = curl_init($trelloapiurl);

            curl_setopt($ch, CURLOPT_URL, $trelloapiurl);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_exec($ch);

            curl_close($ch);
        } catch (\Exception $e) {
            \core\notification::error($e->getMessage());
        }
    }
}
