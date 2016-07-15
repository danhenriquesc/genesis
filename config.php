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

$THEME->name = 'genesis';

////////////////////////////////////////////////////
// Name of the theme. Most likely the name of
// the directory in which this file resides.
////////////////////////////////////////////////////

$THEME->parents = array('canvas','base');

/////////////////////////////////////////////////////
// Which existing theme(s) in the /theme/ directory
// do you want this theme to extend. A theme can
// extend any number of themes. Rather than
// creating an entirely new theme and copying all
// of the CSS, you can simply create a new theme,
// extend the theme you like and just add the
// changes you want to your theme.
////////////////////////////////////////////////////

$sliderPlugin = get_config('theme_genesis', 'sliderplugin');

$THEME->sheets = array(/*'canvas',*/'core','base','course','fontawesome','captionhover','default','frontpage','responsive','login');

if($sliderPlugin == 'content')
    $THEME->sheets[] = 'contentslider';
else if($sliderPlugin == 'plume')
    $THEME->sheets[] = 'plumeslider';

////////////////////////////////////////////////////
// Name of the stylesheet(s) you've including in
// this theme's /styles/ directory.
////////////////////////////////////////////////////

$THEME->parents_exclude_sheets = array('base'=>array('pagelayout','course'),'canvas'=>array('pagelayout','text') );

////////////////////////////////////////////////////
// An array of stylesheets not to inherit from the
// themes parents
////////////////////////////////////////////////////

$THEME->enable_dock = false;

////////////////////////////////////////////////////
// Do you want to use the new navigation dock?
////////////////////////////////////////////////////

//$THEME->editor_sheets = array('editor');

////////////////////////////////////////////////////
// An array of stylesheets to include within the
// body of the editor.
////////////////////////////////////////////////////

$frontpageArray = array("side-pre","side-post","");
$sidebar['frontpage'] = get_config('theme_genesis', 'frontpagesidebar');
if(!in_array($sidebar['frontpage'], $frontpageArray)){
    $sidebar['frontpage'] = "";
}

$generalArray = array("side-pre","side-post");
$sidebar['general'] = get_config('theme_genesis', 'generalsidebar');
if(!in_array($sidebar['general'], $generalArray)){
    $sidebar['general'] = "side-pre";
}


$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    // Standard layout with blocks, this is recommended for most pages with general information
    'standard' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'course' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array($sidebar['frontpage']),
        'defaultregion' => $sidebar['frontpage'],
        'options' => array('nosearch'=>true,'topbutton'=>'login'),
    ),
    'admin' => array(
        'file' => 'admin.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'ararazu_settings' => array(
        'file' => 'settings.php',
        'regions' => array(),
        'defaultregion' => ''
    ),
    'mydashboard' => array(
        'file' => 'my.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general'],
        'options' => array('langmenu'=>true,'topbutton'=>'logout'),
    ),
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
    'login' => array(
        'file' => 'login.php',
        'regions' => array(),
        'options' => array('nomenubar'=>true,'noslider'=>true,'nosearch'=>true,'topbutton'=>'home'),
    ),
    'popup' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'noblocks'=>true, 'nonavbar'=>true, 'nocourseheaderfooter'=>true),
    ),
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nocoursefooter'=>true),
    ),
    'maintenance' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocourseheaderfooter'=>true),
    ),
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocourseheaderfooter'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true, 'nocourseheaderfooter'=>true),
    ),
    'report' => array(
        'file' => 'general.php',
        'regions' => array($sidebar['general']),
        'defaultregion' => $sidebar['general']
    ),
);

///////////////////////////////////////////////////////////////
// These are all of the possible layouts in Moodle. The
// simplest way to do this is to keep the theme and file
// variables the same for every layout. Including them
// all in this way allows some flexibility down the road
// if you want to add a different layout template to a
// specific page.
///////////////////////////////////////////////////////////////

$THEME->csspostprocess = 'genesis_process_css';

////////////////////////////////////////////////////
// Allows the user to provide the name of a function
// that all CSS should be passed to before being
// delivered.
////////////////////////////////////////////////////

$THEME->javascripts = array('modernizr.custom.captionhover','modernizr.custom','jquery211min','jqueryeasing13');

////////////////////////////////////////////////////
// An array containing the names of JavaScript files
// located in /javascript/ to include in the theme.
// (gets included in the head)
////////////////////////////////////////////////////

$THEME->javascripts_footer = array();

if($sliderPlugin == 'content'){
    $THEME->javascripts_footer[] = 'jquery.cslider';
    $THEME->javascripts_footer[] = 'toucheffects';
}
else if($sliderPlugin == 'plume'){
    $THEME->javascripts_footer[] = 'plumeslider';
}

$THEME->javascripts_footer[] = 'genesis.custom';

////////////////////////////////////////////////////
// As above but will be included in the page footer.
////////////////////////////////////////////////////

$THEME->larrow = "/";

////////////////////////////////////////////////////
// Overrides the left arrow image used throughout
// Moodle
////////////////////////////////////////////////////

$THEME->rarrow = "/";

////////////////////////////////////////////////////
// Overrides the right arrow image used throughout Moodle
////////////////////////////////////////////////////

// $THEME->parents_exclude_javascripts

////////////////////////////////////////////////////
// An array of JavaScript files NOT to inherit from
// the themes parents
////////////////////////////////////////////////////

// $THEME->plugins_exclude_sheets

////////////////////////////////////////////////////
// An array of plugin sheets to ignore and not
// include.
////////////////////////////////////////////////////

$THEME->rendererfactory = "theme_overridden_renderer_factory";

////////////////////////////////////////////////////
// Sets a custom render factory to use with the
// theme, used when working with custom renderers.
////////////////////////////////////////////////////