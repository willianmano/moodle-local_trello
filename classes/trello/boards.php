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
 * Trello boards request class
 *
 * @package    local_trello
 * @copyright  2020 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_trello\trello;

defined('MOODLE_INTERNAL') || die();

class boards extends request {
    /* The trello target object. */
    protected $target = 'boards';

    /**
     * Cretes a new board and returns it id
     *
     * @param $name
     * @param bool $defaultlists
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function create($name, $defaultlists = false) {
        $response = $this->post([
            'name' => $name,
            'defaultLists' => $defaultlists,
        ]);

        if ($response) {
            return $response->id;
        }

        return false;
    }
}
