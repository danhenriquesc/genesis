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


/**
 * Makes our changes to the CSS
 *
 * @param string $css
 * @param theme_config $theme
 * @return string 
 */
function genesis_process_css($css, $theme) {
    global $CFG;
    $themecolor = $theme->settings->themecolor;
    
    switch ($themecolor) {
        case 'blue':
            $color1 = "#00A5B6";
            $color2 = "#003050";
            $color3 = "#0094A3";
            $color4 = "#CADD09";
            break;
        case 'green':
            $color1 = "#5DBB71";
            $color2 = "#27736F";
            $color3 = "#4F9F60";
            $color4 = "#EDDC2A";
            break;
        case 'orange':
            $color1 = "#D58303";
            $color2 = "#5F6366";
            $color3 = "#C28425";
            $color4 = "#FED060";
            break;
        case 'custom':
            $color1 = $theme->settings->customColorScheme1;
            $color2 = $theme->settings->customColorScheme2;
            $color3 = $theme->settings->customColorScheme3;
            $color4 = $theme->settings->customColorScheme4;
            break;
    }

    $customCSS = '';
    $sliderPlugin = get_config('theme_genesis', 'sliderplugin');

    if($sliderPlugin == 'plume'){
        $slideritems = json_decode($theme->settings->slideshowdata);

        for($x=1;$x<=sizeof($slideritems);$x++){
            $customCSS .= '.bg-img-'.$x.' {
                               background-image: url('.$slideritems[$x-1]->image.');
                           }';
        }

        if(trim(get_config('theme_genesis', 'sliderinsidebackground')) == ""){
            $customCSS .= '.bg-img-custom {
                               background-image: url('.$slideritems[0]->image.');
                           }';
        }else{
            $customCSS .= '.bg-img-custom {
                               background-image: url('.trim(get_config('theme_genesis', 'sliderinsidebackground')).');
                           }';
        }
    }

    $customCSS .= $theme->settings->customCSS;

    $css = str_replace("[[setting:color1]]", $color1, $css);
    $css = str_replace("[[setting:color2]]", $color2, $css);
    $css = str_replace("[[setting:color3]]", $color3, $css);
    $css = str_replace("[[setting:color4]]", $color4, $css);
    $css = str_replace("[[setting:logoHeight]]", $theme->settings->logoHeight.'px', $css);
    $css = str_replace("[[setting:headerPadding]]", $theme->settings->headerPadding.'px', $css);
    $css = str_replace("[[setting:menuMarginTop]]", $theme->settings->menuMarginTop.'px', $css);
    $css = str_replace("[[setting:footermod_aboutus_whitelogo]]", $theme->settings->footermod_aboutus_whitelogo, $css);
    $css = str_replace("[[setting:fontFamily]]", ucfirst($theme->settings->font), $css);
    $css = str_replace("[[setting:customCSS]]", $customCSS, $css);
    $css = str_replace("[[setting:sliderHeight]]", $theme->settings->sliderheight, $css);
    $css = str_replace("[[setting:bgcolor]]", $theme->settings->bgcolor, $css);
    $css = str_replace("[[setting:bgpattern]]", ((isset($theme->settings->bgpatternCustom) && trim($theme->settings->bgpatternCustom) != "")?$theme->settings->bgpatternCustom:$CFG->wwwroot."/theme/genesis/pix/patterns/".$theme->settings->bgpattern), $css);
    $css = str_replace("[[setting:bgimage]]", $theme->settings->bgimage, $css);
    $css = str_replace("[[setting:fontDir]]", $CFG->wwwroot.'/theme/genesis/fonts/', $css);

    // Return the CSS
    return $css;
}

?>