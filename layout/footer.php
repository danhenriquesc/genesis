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

?>
<div id="footer" class="row">
    <div class="sklt-container">
        <div class="one-third column">
            <?php echo $OUTPUT->footermod("module1"); ?>
        </div> 
        <div class="one-third column">
            <?php echo $OUTPUT->footermod("module2"); ?>
        </div>
        <div class="one-third column omega">
            <?php echo $OUTPUT->footermod("module3"); ?>
        </div>
    </div>
</div>
<div id="footerend" class="row">
    <div class="sklt-container">
        <div class="seven columns">
            <div id="footerendleft">
                <?php echo $OUTPUT->copyright(); ?>
            </div>
        </div>
        <div class="nine columns float-right">
            <div id="footerendright">
                <?php echo $OUTPUT->socialicons('footer'); ?>
            </div>
        </div>
    </div>
</div>