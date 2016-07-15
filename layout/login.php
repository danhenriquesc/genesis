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

    if(isloggedin())
        redirect ($CFG->wwwroot);
    
    global $errormsg;

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

    $show_instructions = get_config('theme_genesis','showRegisterInstructions');
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
        <?php echo "<div style='display: none;'>".$OUTPUT->main_content()."</div>"; ?>
        <?php include 'header.php'; ?>
        
        <div id="contentarea" class="row">
            <div class="sklt-container">
                <div class="sixteen columns">
                    <br>
                    <center>
                        <a href="<?php echo $CFG->wwwroot; ?>">
                            <?php echo $OUTPUT->logo(); ?>
                        </a>
                    </center>
                    <br>
                </div>
            </div>
            <div class="sklt-container" id="loginContainer">
                <div class="<?php echo (($show_instructions)?'eight':'sixteen');?> columns">
                    <div class="loginbox">
                        <form method="post"  action="<?php echo $CFG->wwwroot; ?>/login/index.php">
                            <div class="leftarea">
                                <p><?php echo get_string('login','theme_genesis');?></p>
                                <div class="clear"></div>
                                <div class="inputarea">
                                    <div>
                                        <label for="name"><?php echo get_string('username','theme_genesis');?></label>
                                        <input type="text" name="username"/>
                                    </div>
                                    <div>
                                        <label for="password"><?php echo get_string('password','theme_genesis');?></label>
                                        <input type="password" name="password"/>
                                    </div>
                                </div>
                                <div class="remember">
                                    <input type="checkbox" name="rememberusername" value="1"/>
                                    <label><?php echo get_string('remember','theme_genesis');?></label>
                                </div>
                                <a href="forgot_password.php" style="float: right;"><?php echo get_string('forgotuser','theme_genesis');?></a>
                            </div>
                            <input type="submit" value=">"/>
                        </form>

                        <?php if(isset($errormsg) && trim($errormsg) != ""){ ?>
                            <div class="error">
                                <?php echo get_string("invalidlogin"); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="shadow2"></div>
                    <?php echo $OUTPUT->otherLoginMethods($CFG); ?>
                    <br><br>
                </div>
                <?php if ($show_instructions) { ?>
                    <div class="eight columns">
                        <div class="signuppanel">
                            <h2><?php print_string("firsttime") ?></h2>
                            <div class="subcontent">
                                <?php     
                                    if (is_enabled_auth('none')) { // instructions override the rest for security reasons
                                        print_string("loginstepsnone");
                                    } else if ($CFG->registerauth == 'email') {
                                        if (!empty($CFG->auth_instructions)) {
                                            echo format_text($CFG->auth_instructions);
                                        } else {
                                            print_string("loginsteps", "", "signup.php");
                                        } 
                                    ?>
                                        <div class="signupform">
                                            <form action="signup.php" method="get" id="signup">
                                                <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                                            </form>
                                        </div>
                                <?php     
                                    } else if (!empty($CFG->registerauth)) {
                                        echo format_text($CFG->auth_instructions);
                                ?>
                                        <div class="signupform">
                                            <form action="signup.php" method="get" id="signup">
                                                <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                                            </form>
                                        </div>
                                <?php           
                                    } else {
                                        echo format_text($CFG->auth_instructions);
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            include 'footer.php'; 
            echo $OUTPUT->standard_footer_html();
            echo $OUTPUT->standard_end_of_body_html();
        ?>
    </body>
</html>
<?php 
    echo $OUTPUT->forcefooter();
?>