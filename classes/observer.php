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
 * Trello tasks observer.
 *
 * @package    local_trello
 * @copyright  2020 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_trello;

use local_trello\trello\boards;
use local_trello\trello\lists;
use local_trello\trello\cards;

defined('MOODLE_INTERNAL') || die();

class observer {
    /**
     * Observer for \core\event\course_created event.
     *
     * @param \core\event\course_created $event
     *
     * @return boolean
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function course_created(\core\event\course_created $event) {
        $course = $event->get_record_snapshot('course', $event->objectid);

        try {
            $jsontemplateconfig = get_config('local_trello', 'jsontemplate');

            $boards = new boards();

            if (!$jsontemplateconfig) {
                $boards->create($course->fullname, true);

                return true;
            }

            $jsontemplate = json_decode($jsontemplateconfig);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $boards->create($course->fullname, true);

                return true;
            }

            $boardid = $boards->create($course->fullname);

            $lists = new lists();
            $cards = new cards();
            foreach ($jsontemplate as $key => $value) {
                if (!is_string($key)) {
                    continue;
                }

                $listid = $lists->create($key, $boardid);

                if (is_array($value) && !empty($value)) {
                    foreach ($value as $cardname) {
                        if (!is_string($cardname)) {
                            continue;
                        }

                        $cards->create($cardname, $listid);
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            \core\notification::error($e->getMessage());

            return false;
        }
    }
}
