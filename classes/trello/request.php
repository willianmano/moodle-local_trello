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
 * Trello API base request class.
 *
 * @package    local_trello
 * @copyright  2020 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_trello\trello;

defined('MOODLE_INTERNAL') || die();

class request {

    /* Trello Base API. */
    CONST BASE_API_URL = 'https://api.trello.com/1/';

    /* Trello API Key. */
    protected $apikey;
    /* Trello API Token. */
    protected $apitoken;
    /* The trello target object. */
    protected $target;

    /**
     * The class constructor
     *
     * @throws \dml_exception
     */
    public function __construct() {
        $this->apikey = get_config('local_trello', 'apikey');
        $this->apitoken = get_config('local_trello', 'apitoken');
    }

    /**
     * Makes the post api calls
     *
     * @param $params
     *
     * @return bool|mixed
     *
     * @throws \Exception
     */
    public function post($params) {
        global $CFG;

        $parameters = array_merge(['key' => $this->apikey, 'token' => $this->apitoken], $params);

        $trelloapiurl = sprintf(self::BASE_API_URL . $this->target . '?%s', utf8_encode(http_build_query(
            $parameters,
            '',
            '&'
        )));

        try {
            $curlobj = curl_init($trelloapiurl);

            curl_setopt($curlobj, CURLOPT_VERBOSE, 0);
            curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlobj, CURLOPT_POST, 1);
            curl_setopt($curlobj, CURLOPT_HEADER, 0);

            $response = curl_exec($curlobj);

            if ($response === false) {
                if ($CFG->debugdisplay) {
                    throw new \Exception(curl_error($curlobj), curl_errno($curlobj));
                }

                return false;
            }

            curl_close($curlobj);

            return json_decode($response);
        } catch (\Exception $e) {
            if (!$CFG->debugdisplay) {
                throw $e;
            }

            \core\notification::error($e->getMessage());
        }
    }
}
