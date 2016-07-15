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
 * Genesis is a clean and customizable theme.
 *
 * @package     theme_genesis
 * @copyright   2012 Ararazu [Daniel Henrique]
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_theme_genesis_upgrade($oldversion) {
    global $CFG, $DB;

    set_config('frontpage','');
	set_config('frontpageloggedin','');
	set_config('courseswithsummarieslimit','500');

	if ($oldversion < 2015032428) {
		set_config('sliderinsidebackground','','theme_genesis'); 
	}

	if ($oldversion < 2015070228) {
		set_config('showRegisterInstructions','0','theme_genesis'); 
	}

    return true;
}
