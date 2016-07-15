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

	class Tab{
		public $text;
		public $icon;
		public $id;
		public $classes = null;
		public $options = null;

		function __construct($t, $ic, $i, $c = null){
			$this->text    = $t;
			$this->icon    = $ic;
			$this->id      = $i;
			$this->classes = $c;
		}

		public function addOption($type, $id, $title, $description, $default = null, $options = null, $classes = null){
			$this->options[] = array(
				'type' 			=> $type,
				'id'   			=> $id,
				'title'			=> $title,
				'description'	=> $description,
				'default'		=> $default,
				'options'		=> $options,
				'classes'		=> $classes
			);
		}
	}
?>