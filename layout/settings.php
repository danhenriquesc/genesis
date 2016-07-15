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

    if(!is_siteadmin()){
        redirect($CFG->wwwroot);
    }

    $hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
    $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
    $showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
    $showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);
    $courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
    if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
        $courseheader = $OUTPUT->course_header();
        $coursecontentheader = $OUTPUT->course_content_header();
        if (empty($PAGE->layout_options['nocoursefooter'])) {
            $coursecontentfooter = $OUTPUT->course_content_footer();
            $coursefooter = $OUTPUT->course_footer();
        }
    }
    
    $bodyclasses = array();
    if ($showsidepre && !$showsidepost) {
        if (!right_to_left()) {
            $bodyclasses[] = 'side-pre-only';
        } else {
            $bodyclasses[] = 'side-post-only';
        }
    } else if ($showsidepost && !$showsidepre) {
        if (!right_to_left()) {
            $bodyclasses[] = 'side-post-only';
        } else {
            $bodyclasses[] = 'side-pre-only';
        }
    } else if (!$showsidepost && !$showsidepre) {
        $bodyclasses[] = 'content-only';
    }
?>

<?php echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?> class="<?php echo $OUTPUT->getHTMLLayout() ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $PAGE->title; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="theme-color" content="<?php echo $OUTPUT->getColor(2); ?>">
            
        <?php echo $OUTPUT->loadGoogleFont(); ?>

        <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>">
        
        <?php
            $moodleVersion = $CFG->branch;

            if($moodleVersion == '25')
                $settingsURL = '/theme/'. current_theme() . '/settings';
            else
                $settingsURL = '/theme/'. $PAGE->theme->name . '/settings';

            $PAGE->requires->css($settingsURL.'/css/style.css');

            $PAGE->requires->css($settingsURL.'/inc/colorpicker/css/colorpicker.css');
            $PAGE->requires->css($settingsURL.'/inc/colorpicker/css/layout.css');

            $PAGE->requires->css($settingsURL.'/inc/codemirror/lib/codemirror.css');
            $PAGE->requires->css($settingsURL.'/inc/codemirror/addon/hint/show-hint.css');
            $PAGE->requires->css($settingsURL.'/inc/codemirror/theme/monokai.css');

            echo $OUTPUT->standard_head_html() 
        ?>

        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/colorpicker/js/colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/colorpicker/js/eye.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/colorpicker/js/utils.js"></script>

        
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/lib/codemirror.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/addon/hint/show-hint.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/addon/hint/css-hint.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/addon/hint/javascript-hint.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/mode/css/css.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/mode/javascript/javascript.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/addon/edit/matchbrackets.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/addon/edit/closebrackets.js"></script>
        <script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/inc/codemirror/keymap/sublime.js"></script>

    </head>
    <body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
        <?php echo $OUTPUT->standard_top_of_body_html(); ?>
        <?php include 'header.php'; ?>
                
        <div id="contentarea" class="row">
            <div class="sklt-container">
                <div class="sixteen columns">
                    <div id="page">
                        <div id="ie6-container-wrap">
                            <div id="outercontainer">
                                <div id="container">
    				                <div id="innercontainer">
                                        <div id="page-content">
                                            <div id="region-main-box">
                                                <div id="region-post-box">
                                                    <div id="region-main-wrap">
                                                        <div id="region-main">
                                                            <div class="region-content">
                                                                <?php echo $coursecontentheader; ?>
                                                                <?php echo $OUTPUT->main_content() ?>
                                                                <?php echo $coursecontentfooter; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php 
            include 'footer.php';
            echo $OUTPUT->standard_end_of_body_html();
        ?>
    </body>
</html>

<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/tabs.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/imageUrlPreview.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/list.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/slideshow.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/linkbox.js"></script>
<script type="text/javascript" src="<?php echo $CFG->wwwroot.$settingsURL; ?>/js/thumbList.js"></script>

<script type="text/javascript">
      var editor = CodeMirror.fromTextArea(document.getElementById("id-customCSS"), {
        lineNumbers: true,
        extraKeys: {"Ctrl-Space": "autocomplete"},
        mode: {name: "css", globalVars: true},
        autoCloseBrackets: true,
        matchBrackets: true,
        keyMap: "sublime",
        theme: "monokai"
      });

      var editor2 = CodeMirror.fromTextArea(document.getElementById("id-googleAnalytics"), {
        lineNumbers: true,
        extraKeys: {"Ctrl-Space": "autocomplete"},
        mode: {name: "javascript", globalVars: true},
        autoCloseBrackets: true,
        matchBrackets: true,
        keyMap: "sublime",
        theme: "monokai"
      });
</script>