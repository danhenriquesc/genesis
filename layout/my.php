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
    
    /* Sidebar */
    $sidebar = "";
    if($showsidepre)
        $sidebar = "LEFT";
    else if($showsidepost)
        $sidebar = "RIGHT";
    else
        $sidebar = "NONE";
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
        
        <?php echo $OUTPUT->googleAnalytics() ?>
        <?php echo $OUTPUT->standard_head_html() ?>
    </head>
    <body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
        <?php echo $OUTPUT->standard_top_of_body_html(); ?>
        <?php include 'header.php'; ?>
        
        <?php echo $OUTPUT->slider('general'); ?>
        
        <div id="contentarea" class="row">
            <div class="sklt-container">
                
                <?php 
                    echo $OUTPUT->breadcrumb($PAGE);
                ?>

                <?php if($sidebar == "LEFT") { ?>
                    <div class="four columns leftsidebar">
                        <div id="region-pre" class="block-region">
                            <div class="region-content">
                                <?php echo $OUTPUT->blocks_for_region('side-pre'); ?>
                            </div>
                        </div>
                    </div>
                <?php } else if ($hassidepre) { 
                        echo $OUTPUT->blocks_for_region('side-pre'); 
                    }
                ?>
                
                <?php
                    /* Verifying current page and special my homepage */
                    $specialPages[] = str_replace("http://", "", str_replace("https://", "", $CFG->wwwroot.'/my/'));
                    $specialPages[] = str_replace("http://", "", str_replace("https://", "", $CFG->wwwroot.'/my/index.php'));
                    $specialPages[] = str_replace("http://", "", str_replace("https://", "", $CFG->wwwroot.'/my'));
                    $currentPage = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

                    $currentPage = str_replace("http://", "", str_replace("https://", "", $currentPage));
                ?>

                <!-- If is MOODLE/my/ -->
                <?php if (in_array($currentPage, $specialPages)) { ?>
                    <!-- Courses Header -->

                    <?php 
                        echo "<div class='display-none'>".$OUTPUT->main_content()."</div>"; 
                    ?>
                    
                    <div class="<?php echo (($sidebar == "NONE")?"sixteen":"twelve"); ?> columns">

                        <div class="<?php echo (($sidebar != "NONE")?"twelve":"sixteen"); ?> columns alpha" id="featuredCourses">
                            <?php echo get_string('mycourses','theme_genesis');?>
                            <div id="allCourses">
                                <a href="<?php echo $CFG->wwwroot; ?>/course/"><div><?php echo get_string('allcourses','theme_genesis');?></div></a>
                            </div>
                        </div>
                        
                        <div class="<?php echo (($sidebar == "NONE")?"sixteen":"twelve"); ?> columns alpha omega sklt-container">
                            <!-- Courses List -->
                            <?php 
                                echo $OUTPUT->mycourses($CFG,$sidebar);
                            ?>
                        </div>

                    </div>
                <!-- If is not -->
                <?php } else { ?>
                    <div class="<?php echo (($sidebar == "NONE")?"sixteen":"twelve"); ?> columns">
                        <div id="page-wrapper">
                            <div id="page">
                                <div id="page-content">
                                    <div id="region-main-box">
                                        <div id="region-pre-box">
                                            <div id="region-main">
                                                <div class="region-content">
                                                    <?php if(isset($coursecontentheader)) echo $coursecontentheader; ?>
                                                    <?php echo $OUTPUT->main_content() ?>
                                                    <?php if(isset($coursecontentfooter)) echo $coursecontentfooter; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                <?php }?>

                <?php if($sidebar == "RIGHT") { ?>
                    <div class="four columns omega rightsidebar">
                        <div id="region-post" class="block-region">
                            <div class="region-content">
                                <?php echo $OUTPUT->blocks_for_region('side-post'); ?>
                            </div>
                        </div>
                    </div>
                <?php } else if ($hassidepost) { 
                        echo $OUTPUT->blocks_for_region('side-post'); 
                    }
                ?>
            </div>
        </div>
        
        <?php 
            include 'footer.php';
            echo $OUTPUT->standard_footer_html();
            echo $OUTPUT->standard_end_of_body_html();
        ?>
    </body>
</html>