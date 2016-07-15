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

class theme_genesis_core_renderer extends core_renderer {
    protected function googleAnalytics(){
        return get_config('theme_genesis', 'googleAnalytics');
    }

    protected function breadcrumb($PAGE){
        $breadcrumb = get_config('theme_genesis', 'breadcrumb');
        $editPageButton = get_config('theme_genesis', 'editPageButton');
        $content = '';
        
        if(($breadcrumb + $editPageButton) > 0){
            $content = '<div class="sixteen columns">
                            <div class="navbar">
                                <div class="wrapper clearfix">';

            if($breadcrumb){
                $content .=             '<div class="breadcrumb">'.$this->navbar().'</div>';
            }
            if($editPageButton){
                $content .=             '<div class="navbutton">'.$PAGE->button.'</div>';
            }

            $content .=         '</div>
                            </div>
                        </div>';
        }

        return $content;
    }
    private function footermod_aboutus(){
        $logourl = get_config('theme_genesis', 'footermod_aboutus_whitelogo');
        $text = get_config('theme_genesis', 'footermod_aboutus_text');
        
        $content = '<div class="footermod footermod_aboutus">';
        
        if(!$logourl || trim($logourl)=="")
            $content .= '<div id="defaultlogowhite"></div>';
        else{
            $content .= '<div id="logowhite"></div>';
        }
        
        $content .= "<p>".$text."</p>";
        
        $content .= "</div>";
        
        return $content;
    }

    private function footermod_links(){
        $links = json_decode(get_config('theme_genesis', 'footermod_links'));
        
        $content = '<div class="footermod footermod_links">'; 
        $content .= '<p class="title">'.get_string('links','theme_genesis').'</p>';
        
        $content .= '<ul class="links">';
        
        for($x=0;$x<sizeof($links);$x++){
            $content .= '<li><a target="blank" href="'.$links[$x]->link.'">'.$links[$x]->text.'</a></li>';
        }
        
        $content .= '</ul>';
        $content .= '</div>';
        
        return $content;
    }
    
    private function footermod_contactinfo(){
        $address = get_config('theme_genesis', 'footermod_contact_address');
        $city = get_config('theme_genesis', 'footermod_contact_city');
        $phone = get_config('theme_genesis', 'footermod_contact_phone');
        $mail = get_config('theme_genesis', 'footermod_contact_mail');
        
        $content = '<div class="footermod footermod_contactinfo">';
        
        $content .= '<p class="title">'.get_string('contactinfo','theme_genesis').'</p>';
        
        $content .= '<ul class="contactinfos">';
        $content .= '<li><i class="fa fa-home"></i>'.$address.'</li>';
        $content .= '<li><i class="fa fa-globe"></i>'.$city.'</li>';
        $content .= '<li><i class="fa fa-phone"></i>'.$phone.'</li>';
        $content .= '<li><i class="fa fa-envelope-o"></i>'.$mail.'</li>';
        $content .= '</ul>';
        
        $content .= "</div>";
        
        return $content;
    }
    
    private function footermod_image(){
        $title = get_config('theme_genesis', 'footermod_image_title');
        $src = get_config('theme_genesis', 'footermod_image_url');
        
        $content = '<div class="footermod footermod_image">';
        
        $content .= '<p class="title">'.$title.'</p>';
        $content .= '<div class="image"><img src="'.$src.'"/></div>';
        
        $content .= "</div>";
        
        return $content;
    }
    
    protected function footermod($modulearea){
        $module = get_config("theme_genesis","footer".$modulearea);
        if(trim($module)!="" && trim($module)!="none"){
            $module = "footermod_".$module;
            return $this->$module();
        }else{
            return ' ';
        }
    }
    
    protected function linkbox($CFG,$sidebar){
        $linkboxitems = json_decode(get_config('theme_genesis', 'linkboxdata'));
        $content = '';
        
        $inline = 0;
        if($sidebar == "NONE")
            $inline = 4;
        else
            $inline = 3;
        
        for($x=1;$x<=sizeof($linkboxitems);$x++){
            $align = "";
            if($x % $inline == 1)
                $align = "alpha";
            else if($x % $inline == 0)
                $align = "omega";
            
            $content .= '<div class="four columns linkbox '.(($inline==4 && $align!="alpha")?"four-box-per-line":"").' '.$align.'">
                            <div class="linkboxicon"><i class="fa fa-5x '.$linkboxitems[$x-1]->icon.'"></i></div>
                            <p class="title">'.$linkboxitems[$x-1]->title.'</p>
                            <p class="description">'.$linkboxitems[$x-1]->text.'</p>'.
                            ( (isset($linkboxitems[$x-1]->link) && trim($linkboxitems[$x-1]->link) != "")?'<a target="_blank" href="'.$linkboxitems[$x-1]->link.'"><div class="readmore">'.get_string('readmore','theme_genesis').'</div></a>':'')
                        .'</div>';
        }
        return $content;
    }
    protected function mycourses($CFG,$sidebar){
        $mycourses = enrol_get_users_courses($_SESSION['USER']->id);
        
        $courselist = array();
        foreach ($mycourses as $key=>$val){
            $courselist[] = $val->id;
        }
        
        $content = '';
        
        $coursesinline = 0;
        
        if($sidebar == "NONE")
            $coursesinline = 4;
        else
            $coursesinline = 3;
        
        for($x=1;$x<=sizeof($courselist);$x++){
            $course = get_course($courselist[$x-1]);
            $courseName = get_config('theme_genesis','courseName');
            $title = $course->$courseName;
            
            if ($course instanceof stdClass) {
                require_once($CFG->libdir. '/coursecatlib.php');
                $course = new course_in_list($course);
            }

            $url = $CFG->wwwroot."/theme/genesis/pix/coursenoimage.jpg";
            foreach ($course->get_course_overviewfiles() as $file) {
                $isimage = $file->is_valid_image();
                $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                        '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                        $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                if (!$isimage) {
                    $url = $CFG->wwwroot."/theme/genesis/pix/coursenoimage.jpg";
                }
            }
            
            $align = "";
            if($x % $coursesinline == 1)
                $align = "alpha";
            else if($x % $coursesinline == 0)
                $align = "omega";
                    
            $content .= '<div class="four columns course '.$align.'">
                            <ul class="grid cs-style-3">
                                <li>
                                    <figure>
                                        <a href="'.$CFG->wwwroot.'/course/view.php?id='.$courselist[$x-1].'">   
                                            <img src="'.$url.'" alt="'.$title.'">
                                        </a>
                                        <figcaption>
                                            <h3>'.$title.'</h3>
                                            <div>
                                                <a href="'.$CFG->wwwroot.'/course/view.php?id='.$courselist[$x-1].'">'.get_string('takealook','theme_genesis').'</a>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </li>
                            </ul>
                         </div>';
        }
                    
        return $content;
    }
    
    protected function featuredcourses($CFG,$sidebar){
        $featuredcourses = get_config('theme_genesis', 'featuredcourses');
        $courselist = json_decode($featuredcourses);
        $content = '';
        
        $coursesinline = 0;
        
        if($sidebar == "NONE")
            $coursesinline = 4;
        else
            $coursesinline = 3;
        
        for($x=1;$x<=sizeof($courselist);$x++){
            $course = get_course($courselist[$x-1]);
            $courseName = get_config('theme_genesis','courseName');
            $title = $course->$courseName;
            
            if ($course instanceof stdClass) {
                require_once($CFG->libdir. '/coursecatlib.php');
                $course = new course_in_list($course);
            }

            $url = $CFG->wwwroot."/theme/genesis/pix/coursenoimage.jpg";
            foreach ($course->get_course_overviewfiles() as $file) {
                $isimage = $file->is_valid_image();
                $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                        '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                        $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                if (!$isimage) {
                    $url = $CFG->wwwroot."/theme/genesis/pix/coursenoimage.jpg";
                }
            }
            
            $align = "";
            if($x % $coursesinline == 1)
                $align = "alpha";
            else if($x % $coursesinline == 0)
                $align = "omega float-right";
                    
            $content .= '<div class="four columns course '.(($coursesinline==4 && $align!="alpha")?"four-box-per-line":"").' '.$align.'">
                            <ul class="grid cs-style-3">
                                <li>
                                    <figure>
                                        <a href="'.$CFG->wwwroot.'/course/view.php?id='.$courselist[$x-1].'">
                                            <img height="280" width="280" src="'.$url.'" alt="'.$title.'">
                                        </a>
                                        <figcaption>
                                            <h3>'.$title.'</h3>
                                            <div>
                                                <a href="'.$CFG->wwwroot.'/course/view.php?id='.$courselist[$x-1].'">'.get_string('takealook','theme_genesis').'</a>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </li>
                            </ul>
                        </div>';
        }

        return $content;
    }
    
    protected function menu(){

        $menuitems = json_decode(get_config('theme_genesis', 'menudata'));
        $content = '<div id="menu">
                        <ul>';

        $currentpage = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $currentpage = str_replace("/my/", "", $currentpage);
        $currentpage = str_replace("/#", "", $currentpage);

        if(stristr($currentpage,'.php')){
            $exp = explode("/", $currentpage);
            $currentpage = '';
            for($i=0; $i<sizeof($exp)-1;$i++){
                $currentpage .= $exp[$i].'/';
            }
        }

        if($currentpage[strlen($currentpage)-1] == '/') $currentpage = substr($currentpage, 0, -1);

        for($x=0;$x<sizeof($menuitems);$x++){

            if($menuitems[$x]->deep == '1'){
                if($menuitems[$x]->link[strlen($menuitems[$x]->link)-1] == '/') $menuitems[$x]->link = substr($menuitems[$x]->link, 0, -1);

                $content .= '<li '.((($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1')?'':'class="has-sub"').'>
                                <a href="'.$menuitems[$x]->link.'"'.(( $currentpage == str_replace("http://", "", str_replace("https://", "", $menuitems[$x]->link)))?' class="active"':'').'><span data-hover="'.$menuitems[$x]->text.'">'.$menuitems[$x]->text.'</span></a>';
                if(($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1'){
                    $content .= '</li>';
                }else{
                    $content .= '<ul>';
                }
            }else if($menuitems[$x]->deep == '2'){
                $content .= '       <li>
                                        <a href="'.$menuitems[$x]->link.'"><span data-hover="'.$menuitems[$x]->text.'">'.$menuitems[$x]->text.'</span></a>
                                    </li>';
                if(($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1'){
                    $content .= '</ul>
                             </li>';
                }
            }
        }
        
        $content .= '   </ul>   
                     </div>';

        return $content;
    }

    protected function responsive_menu(){

        $menuitems = json_decode(get_config('theme_genesis', 'menudata'));
       
        $content = '';

        /* Responsive Menu */
        $content .= '   <div id="responsive_menu_button"></div>';

        $content .= '<div id="responsive_menu">';
        $content .= '   <ul class="rp-menu">';

        for($x=0;$x<sizeof($menuitems);$x++){

            if($menuitems[$x]->deep == '1'){
                if($menuitems[$x]->link[strlen($menuitems[$x]->link)-1] == '/') $menuitems[$x]->link = substr($menuitems[$x]->link, 0, -1);

                $content .= '<li>
                                <a href="'.$menuitems[$x]->link.'">'.$menuitems[$x]->text.'</a>';
                if(($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1'){
                    $content .= '</li>';
                }else{
                    $content .= '<ul'.((($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1')?'':' class="has-submenu"').'>';
                }
            }else if($menuitems[$x]->deep == '2'){
                $content .= '       <li>
                                        <a href="'.$menuitems[$x]->link.'">'.$menuitems[$x]->text.'</a>
                                    </li>';
                if(($x+1)>=sizeof($menuitems) || $menuitems[$x+1]->deep == '1'){
                    $content .= '</ul>
                             </li>';
                }
            }
        }

        $content .= '   </ul>';
        $content .= '</div>';



        return $content;
    }
    
    public function logo(){
        $logourl = get_config('theme_genesis', 'logourl');
        $content = '';
        if(!$logourl || trim($logourl)=="")
            $content = '<div id="defaultlogo"></div>';
        else{
            $content = '<div id="logo">
                            <img src="'.$logourl.'"/>
                        </div>';
        }
        return $content;
    }

    public function favicon() {
        $faviconurl = get_config('theme_genesis', 'faviconurl');
        if(!$faviconurl || trim($faviconurl)=="")
            $faviconurl = $this->page->theme->pix_url('favicon', 'theme');
        return $faviconurl;
    }

    protected function copyright(){
        $copyright = get_config('theme_genesis', 'copyright');
        return $copyright;
    }

    protected function socialicons($area){
        $hassocialicons = get_config('theme_genesis', $area.'socialicon');
        
        $social_facebook = get_config('theme_genesis','social_facebook');
        $social_twitter = get_config('theme_genesis','social_twitter');
        $social_gplus = get_config('theme_genesis','social_gplus');
        $social_youtube = get_config('theme_genesis','social_youtube');
        $social_vimeo =  get_config('theme_genesis','social_vimeo');
        $social_pinterest = get_config('theme_genesis','social_pinterest');
        $social_flickr = get_config('theme_genesis','social_flickr');
        $social_rss = get_config('theme_genesis','social_rss');
        $social_dribbble = get_config('theme_genesis','social_dribbble');
        $social_linkedin = get_config('theme_genesis','social_linkedin');
        $social_tumblr = get_config('theme_genesis','social_tumblr');
        $social_behance = get_config('theme_genesis','social_behance');
        $social_wordpress = get_config('theme_genesis','social_wordpress');
        
        $content = '<ul class="social-icons">';
        
        if($hassocialicons){
            if(isset($social_facebook) && trim($social_facebook)!=""){
                $content .= '<li><a href="'.$social_facebook.'"><i class="fa fa-facebook fa-lf"></i></a></li> ';
            }
            if(isset($social_twitter) && trim($social_twitter)!=""){
                $content .= '<li><a href="'.$social_twitter.'"><i class="fa fa-twitter fa-lf"></i></a></li> ';
            }
            if(isset($social_gplus) && trim($social_gplus)!=""){
                $content .= '<li><a href="'.$social_gplus.'"><i class="fa fa-google-plus fa-lf"></i></a></li> ';
            }
            if(isset($social_youtube) && trim($social_youtube)!=""){
                $content .= '<li><a href="'.$social_youtube.'"><i class="fa fa-youtube fa-lf"></i></a></li> ';
            }
            if(isset($social_vimeo) && trim($social_vimeo)!=""){
                $content .= '<li><a href="'.$social_vimeo.'"><i class="fa fa-vimeo-square fa-lf"></i></a></li> ';
            }
            if(isset($social_pinterest) && trim($social_pinterest)!=""){
                $content .= '<li><a href="'.$social_pinterest.'"><i class="fa fa-pinterest fa-lf"></i></a></li> ';
            }
            if(isset($social_flickr) && trim($social_flickr)!=""){
                $content .= '<li><a href="'.$social_flickr.'"><i class="fa fa-flickr fa-lf"></i></a></li> ';
            }
            if(isset($social_rss) && trim($social_rss)!=""){
                $content .= '<li><a href="'.$social_rss.'"><i class="fa fa-rss fa-lf"></i></a></li> ';
            }
            if(isset($social_dribbble) && trim($social_dribbble)!=""){
                $content .= '<li><a href="'.$social_dribbble.'"><i class="fa fa-dribbble fa-lf"></i></a></li> ';
            }
            if(isset($social_linkedin) && trim($social_linkedin)!=""){
                $content .= '<li><a href="'.$social_linkedin.'"><i class="fa fa-linkedin fa-lf"></i></a></li> ';
            }
            if(isset($social_tumblr) && trim($social_tumblr)!=""){
                $content .= '<li><a href="'.$social_tumblr.'"><i class="fa fa-tumblr fa-lf"></i></a></li> ';
            }
            if(isset($social_wordpress) && trim($social_wordpress)!=""){
                $content .= '<li><a href="'.$social_wordpress.'"><i class="fa fa-wordpress fa-lf"></i></a></li> ';
            }
        }
        
        $content .= '</ul>';

        return $content;
    }

    protected function slider($pagelayout){
        $sliderPlugin = get_config('theme_genesis', 'sliderplugin');

        if($pagelayout == 'frontpage' || $sliderPlugin == 'plume')
            $slidertype = get_config('theme_genesis', 'slidermode');
        else
            $slidertype = 'banner';
        
        $sliderpattern = "slider".get_config('theme_genesis', 'sliderpattern').get_config('theme_genesis', 'themecolor');
        $slideritems = json_decode(get_config('theme_genesis', 'slideshowdata'));
        
        
        $content = '<div id="sliderarea" class="row '.$sliderpattern.' '.$sliderPlugin.'SliderPlugin">';

        if(get_config("theme_genesis","headerType") != 5 && $sliderPlugin == 'content')
            $content .=     '<div class="shadow1"></div>';

        switch ($slidertype) {
            case 'slideshow':
                if($sliderPlugin == 'content'){
                    $content .= '<div id="slider1" class="da-slider">';

                    for($x=0;$x<sizeof($slideritems);$x++)
                    {
                        $content .= '<div class="da-slide">';
                        $content .= '<h2>'.$slideritems[$x]->title.'</h2>';
                        $content .= '<p>'.$slideritems[$x]->description.'</p>';
                        if((isset($slideritems[$x]->link)) && $slideritems[$x]->link!=""){
                            $content .= '<a target="_blank" href="'.$slideritems[$x]->link.'" class="da-link">'.get_string('readmore','theme_genesis').'</a>';
                        }
                        $content .= '<div class="da-img"><img src="'.$slideritems[$x]->image.'" alt="image01" /></div>';
                        $content .= '</div>';
                    }

                    if(sizeof($slideritems) > 1){
                        $content .= '<nav class="da-arrows">
                                        <span class="da-arrows-prev"></span>
                                        <span class="da-arrows-next"></span>
                                    </nav>';
                    }else{
                        $content .= '<style type="text/css">.da-dots{ display:none; }</style>';
                    }

                    $content .= '</div>';
                }else if ($sliderPlugin == 'plume') {
                    $content .= '<section id="slideshow">
                                    <div id="wrapper">
                                        <div class="plume-slider">';

                    if($pagelayout == 'frontpage'){
                        for($x=0;$x<sizeof($slideritems);$x++){

                            $content .= '           <div id="slide-'.($x+1).'" class="plume-slide">
                                                        <div class="plume-slide-inner">
                                                            <div class="over-pattern dots opacity30"></div><div class="over-color opacity30"></div>
                                                            <div class="bg-img bg-img-'.($x+1).'"></div>
                                                            <div class="plume-slide-content">
                                                                <div class="elem-1 animation ccenter" data-type="easeOutSine" data-time="1000" data-delay="0" data-xy="-50, 0">
                                                                   <div class="vcenter">
                                                                        <h1>'.$slideritems[$x]->title.'</h1>
                                                                        <h2>'.$slideritems[$x]->description.'</h2>'.
                                                                        ( (isset($slideritems[$x]->link) && trim($slideritems[$x]->link) != "")?'<a target="_blank" href="'.$slideritems[$x]->link.'" class="btn">'.get_string('readmore','theme_genesis').'</a>':'')
                                                                    .'</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                        }
                    }else{
                        $content .= '           <div id="slide-1" class="plume-slide">
                                                        <div class="plume-slide-inner">
                                                            <div class="over-pattern dots opacity30"></div><div class="over-color opacity30"></div>
                                                            <div class="bg-img bg-img-custom" style="opacity:1; visibility: visible;"></div>
                                                        </div>
                                                    </div>';
                    }

                    $content .= '           </div><!-- /.plume-slider -->';
                          
                    if(sizeof($slideritems) > 1 && $pagelayout == 'frontpage'){
                        $content .= '           <!-- arrows -->
                                                <span class="nav-arrow prev"></span>
                                                <span class="nav-arrow next"></span>

                                                <!-- bullets -->
                                                <ul class="plume-bullets">';

                                                    for($x=0;$x<sizeof($slideritems);$x++){
                                                        $content .= '<li><a id="bullet-'.($x+1).'" class="nav-bullet" href="#"><div></div></a></li>';
                                                    }
                        $content .= '           </ul>';
                    }

                    $content .= '       </div><!-- /.slider -->
                                    <div class="clear"></div>
                                </section><!-- /#slideshow -->';
                }
                break;
            case 'banner':
                $content .= '<div id="sliderbanner" class="'.$sliderpattern.'"></div>';

            break;

            default: $content .= '';
                break;
        }

        $content .= '</div>';

        return $content;
    }

    protected function get_header($CFG, $menubar, $noslider, $topbutton){
        $headerType = get_config("theme_genesis","headerType");
        if(trim($headerType)!=""){
            $function = "get_header_type".$headerType;
            $this->$function($CFG, $menubar, $noslider, $topbutton);
        }
    }

    protected function get_header_type1($CFG, $menubar, $noslider, $topbutton){
        echo '<header id="header1" class="row header">
                    <div id="topbar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns socialiconsArea">'.$this->socialicons('header');
                                    switch ($topbutton) {
                                        case 'home':
                                            echo '<div id="home" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                        break;
                                        default:
                                            if(isloggedin())
                                                echo '<div id="logout" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                            else
                                                echo '<div id="login" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                    }

                                    if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                        echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                    }else if( (!isloggedin() || $_SESSION['USER']->username == 'guest') && get_config('theme_genesis', 'registerLink')){
                                        echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                    }
        echo                '</div>
                        </div>';                        
        if($noslider){
            echo        '<div class="shadow1"></div>';
        }

        echo        '</div>';

        if($menubar) {
        echo        '<div id="menubar" class="row">
                            <div class="sklt-container">
                                <div class="four columns">
                                    <a href="'.$CFG->wwwroot.'">'.$this->logo().'</a>
                                    '.$this->responsive_menu().'
                                </div>
                                <div class="twelve columns omega">'.$this->menu().'</div>
                            </div>
                    </div>';
        }
                    
        echo '</header>';
    }

    protected function get_header_type2($CFG, $menubar, $noslider, $topbutton){
        echo '<header id="header2" class="row header">
                    <div id="topbar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">';
                                    if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                        echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                    }else if( (!isloggedin() || $_SESSION['USER']->username == 'guest') && get_config('theme_genesis', 'registerLink')){
                                        echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                    }

                                    switch ($topbutton) {
                                        case 'home':
                                            echo '<div id="home" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                        break;
                                        default:
                                            if(isloggedin())
                                                echo '<div id="logout" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                            else
                                                echo '<div id="login" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                    }
        
        echo                '<div class="socialiconsArea">'.$this->socialicons('header').'</div>';
        echo                '</div>
                        </div>';                        
        echo        '</div>';

        if($menubar) {
        echo        '<div id="menubar" class="row">
                            <div class="sklt-container">
                                <div class="four columns">
                                    <a href="'.$CFG->wwwroot.'">'.$this->logo().'</a>
                                    '.$this->responsive_menu().'
                                </div>
                                <div class="twelve columns">'.$this->menu().'</div>
                            </div>
                    </div>';
        }
                    
        echo '</header>';
    }

    protected function get_header_type3($CFG, $menubar, $noslider, $topbutton){
        echo '<header id="header3" class="row header">
                    <div id="topbar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">';
                                    if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                        echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                    }else if( (!isloggedin() || $_SESSION['USER']->username == 'guest') && get_config('theme_genesis', 'registerLink')){
                                        echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                    }

                                    switch ($topbutton) {
                                        case 'home':
                                            echo '<div id="home" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                        break;
                                        default:
                                            if(isloggedin())
                                                echo '<div id="logout" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                            else
                                                echo '<div id="login" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                    }
        echo                    '<div class="socialiconsArea">'.$this->socialicons('header').'</div>
                            </div>

                        </div>';                        
        echo        '</div>';

        if($menubar) {
        echo        '<div id="menubar" class="row">
                            <div class="sklt-container">
                                <div class="four columns">
                                    <a href="'.$CFG->wwwroot.'">'.$this->logo().'</a>
                                    '.$this->responsive_menu().'
                                </div>
                                <div class="twelve columns">'.$this->menu().'</div>
                            </div>
                    </div>';
        }
                    
        echo '</header>';
    }

    protected function get_header_type4($CFG, $menubar, $noslider, $topbutton){
        echo '<header id="header4" class="row header">
                    <div id="topbar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">';
                                    if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                        echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                    }else if( (!isloggedin() || $_SESSION['USER']->username == 'guest') && get_config('theme_genesis', 'registerLink')){
                                        echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                    }

                                    switch ($topbutton) {
                                        case 'home':
                                            echo '<div id="home" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                        break;
                                        default:
                                            if(isloggedin())
                                                echo '<div id="logout" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                            else
                                                echo '<div id="login" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                    }
        echo                    '<div class="socialiconsArea">'.$this->socialicons('header').'</div>
                            </div>
                        </div>';                        
        echo        '</div>';

        if($menubar) {
        echo        '<div id="menubar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">
                                <center>
                                    <a href="'.$CFG->wwwroot.'">'.$this->logo().'</a>
                                </center>
                                '.$this->responsive_menu().'
                            </div>
                        </div>
                    </div>';
        echo        '<div id="submenubar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">'.$this->menu().'</div>
                        </div>
                    </div>';
        }
                    
        echo '</header>';
    }

    protected function get_header_type5($CFG, $menubar, $noslider, $topbutton){
        echo '<header id="header5" class="row header">';

        if($menubar) {
        echo        '<div id="menubar" class="row">
                        <div class="sklt-container">
                            <div class="six columns socialiconsArea">'.$this->socialicons('header').'
                                <div class="loginResponsive">';
                                    switch ($topbutton) {
                                        case 'home':
                                            echo '<div id="home2" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                        break;
                                        default:
                                            if(isloggedin())
                                                echo '<div id="logout2" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                            else
                                                echo '<div id="login2" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                    }

                                    if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                            echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                    }else if( (!isloggedin() || $_SESSION['USER']->username == 'guest') && get_config('theme_genesis', 'registerLink')){
                                        echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                    }                                
            echo                '</div>
                            </div>
                            <div class="four columns">
                                <center>
                                    <a href="'.$CFG->wwwroot.'">'.$this->logo().'</a>
                                </center>
                                '.$this->responsive_menu().'
                            </div>
                            <div class="six columns">';
                                switch ($topbutton) {
                                    case 'home':
                                        echo '<div id="home" class="topbutton"><a href="'.$CFG->wwwroot.'">'.get_string('home','theme_genesis').'</a></div>';
                                    break;
                                    default:
                                        if(isloggedin())
                                            echo '<div id="logout" class="topbutton"><a href="'.$CFG->wwwroot.'/login/logout.php">'.get_string('logout','theme_genesis').'</a></div>';
                                        else
                                            echo '<div id="login" class="topbutton"><a href="'.$CFG->wwwroot.'/login">'.get_string('login','theme_genesis').'</a></div>';
                                }

                                if(isloggedin() && get_config('theme_genesis', 'loggedAs')){
                                        echo '<p id="topText"> '.$this->login_info(false).'</p>';
                                }else if(!isloggedin() && get_config('theme_genesis', 'registerLink')){
                                    echo '<p id="topText"><a href="'.$CFG->wwwroot.'/login/signup.php">'.get_string('register','theme_genesis').'</a></p>';
                                }                                
        echo                '</div>
                        </div>
                    </div>';
        echo        '<div id="submenubar" class="row">
                        <div class="sklt-container">
                            <div class="sixteen columns">'.$this->menu().'</div>
                        </div>
                    </div>';
        }
                    
        echo '</header>';
    }

    protected function loadGoogleFont(){
        $fontFamily = get_config('theme_genesis', 'font');

        switch ($fontFamily) {
            case 'oxygen':
                /* Theme Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>";
                /* Theme Options Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>";
                break;
            case 'lato':
                /* Theme Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>";
                /* Theme Options Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>";
                break;
            case 'roboto':
                /* Theme Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300italic,300,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>";
                /* Theme Options Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>";
                break;
            case 'ubuntu':
                /* Theme & Theme Options Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>";
                break;
            default:
                /* Theme Options Font */
                echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>";
                break;
        }
    }

    protected function getColor($colorIndex){
        $themecolor = get_config('theme_genesis','themecolor');
        $ret = '';
    
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

        switch ($colorIndex) {
            case 1:
                $ret = $color1;
                break;
            case 2:
                $ret = $color3;
                break;
            case 3:
                $ret = $color3;
                break;
            case 4:
                $ret = $color4;
                break;
        }

        return $ret;
    }

    protected function getHTMLLayout(){
        $layoutStyle = get_config('theme_genesis','layoutStyle');
        return $layoutStyle;
    }

    protected function otherLoginMethods($CFG){
        $shibbolethLogin = get_config('theme_genesis', 'shibbolethLogin');
        $guestLogin = get_config('theme_genesis', 'guestLogin');
        $show_instructions = get_config('theme_genesis','showRegisterInstructions');

        echo '<div class="otherLoginMethod">';

        if($shibbolethLogin){
            echo '<a href="'.$CFG->wwwroot.'/auth/shibboleth/index.php" class="shibbolethLogin">'.get_string('loginwith','theme_genesis').' Shibboleth</a>';
        }

        if($guestLogin){
            echo '<div class="subcontent guestsub">
                        <div class="desc">
                            '.get_string('mayAllowGuestAccess','theme_genesis').'        
                        </div>
                        <form action="index.php" method="post" id="guestlogin">
                            <div class="guestform">
                                <input type="hidden" name="username" value="guest">
                                <input type="hidden" name="password" value="guest">
                                <input type="submit" value="'.get_string('loginAsGuest','theme_genesis').'">
                            </div>
                        </form>
                    </div>';
        }

        if(!$show_instructions && !empty($CFG->registerauth)){
            echo '<div class="signupform">
                    <form action="signup.php" method="get" id="signup">
                        <div><input type="submit" value="'.get_string("startsignup").'" /></div>
                    </form>
                </div>';
        }

        echo '</div>';
    }

    protected function forcefooter(){
        echo '<style type="text/css">
                 @media screen and (min-height: 730px) and (min-width: 768px){
                    #footer,#footerend{
                        position: absolute !important;
                        max-width: 1350px !important;
                    }
                 }
             </style>';
    }
    
    protected function render_navigation_node(navigation_node $item) {
        $content = $item->get_content();
        $title = $item->get_title();
        if ($item->icon instanceof renderable && !$item->hideicon) {
            if(trim($content) == 'Genesis')
                $item->icon->pix = 'g/genesis_'.get_config('theme_genesis','themecolor');
            $icon = $this->render($item->icon);
            if(trim($content) == 'Genesis')
                $content = '<b>Genesis</b>';
            $content = $icon.$content; // use CSS for spacing of icons
        }
        if ($item->helpbutton !== null) {
            $content = trim($item->helpbutton).html_writer::tag('span', $content, array('class'=>'clearhelpbutton', 'tabindex'=>'0'));
        }
        if ($content === '') {
            return '';
        }
        if ($item->action instanceof action_link) {
            $link = $item->action;
            if ($item->hidden) {
                $link->add_class('dimmed');
            }
            if (!empty($content)) {
                // Providing there is content we will use that for the link content.
                $link->text = $content;
            }
            $content = $this->render($link);
        } else if ($item->action instanceof moodle_url) {
            $attributes = array();
            if ($title !== '') {
                $attributes['title'] = $title;
            }
            if ($item->hidden) {
                $attributes['class'] = 'dimmed_text';
            }
            $content = html_writer::link($item->action, $content, $attributes);

        } else if (is_string($item->action) || empty($item->action)) {
            $attributes = array('tabindex'=>'0'); //add tab support to span but still maintain character stream sequence.
            if ($title !== '') {
                $attributes['title'] = $title;
            }
            if ($item->hidden) {
                $attributes['class'] = 'dimmed_text';
            }
            $content = html_writer::tag('span', $content, $attributes);
        }
        return $content;
    }

    public function login_info($withlinks = null) {
        global $USER, $CFG, $DB, $SESSION;

        if (during_initial_install()) {
            return '';
        }

        if (is_null($withlinks)) {
            $withlinks = empty($this->page->layout_options['nologinlinks']);
        }

        $loginpage = ((string)$this->page->url === get_login_url());
        $course = $this->page->course;

        $moodleVersion = $CFG->branch;

        if($moodleVersion == '25'){
            if (session_is_loggedinas()) {
                $realuser = session_get_realuser();
                $fullname = fullname($realuser, true);
                if ($withlinks) {
                    $loginastitle = get_string('loginas');
                    $realuserinfo = " [<a href=\"$CFG->wwwroot/course/loginas.php?id=$course->id&amp;sesskey=".sesskey()."\"";
                    $realuserinfo .= "title =\"".$loginastitle."\">$fullname</a>] ";
                } else {
                    $realuserinfo = " [$fullname] ";
                }
            } else {
                $realuserinfo = '';
            }
        }else{
            if (\core\session\manager::is_loggedinas()) {
                $realuser = \core\session\manager::get_realuser();
                $fullname = fullname($realuser, true);
                if ($withlinks) {
                    $loginastitle = get_string('loginas');
                    $realuserinfo = " [<a href=\"$CFG->wwwroot/course/loginas.php?id=$course->id&amp;sesskey=".sesskey()."\"";
                    $realuserinfo .= "title =\"".$loginastitle."\">$fullname</a>] ";
                } else {
                    $realuserinfo = " [$fullname] ";
                }
            } else {
                $realuserinfo = '';
            }
        }

        $loginurl = get_login_url();

        if (empty($course->id)) {
            // $course->id is not defined during installation
            return '';
        } else if (isloggedin()) {
            $context = context_course::instance($course->id);

            $fullname = fullname($USER, true);
            // Since Moodle 2.0 this link always goes to the public profile page (not the course profile page)
            if ($withlinks) {
                $linktitle = get_string('viewprofile');
                $username = "<a href=\"$CFG->wwwroot/user/profile.php?id=$USER->id\" title=\"$linktitle\">$fullname</a>";
            } else {
                $username = $fullname;
            }
            if (is_mnet_remote_user($USER) and $idprovider = $DB->get_record('mnet_host', array('id'=>$USER->mnethostid))) {
                if ($withlinks) {
                    $username .= " from <a href=\"{$idprovider->wwwroot}\">{$idprovider->name}</a>";
                } else {
                    $username .= " from {$idprovider->name}";
                }
            }
            if (isguestuser()) {
                $loggedinas = $realuserinfo.get_string('loggedinasguest');
                if (!$loginpage && $withlinks) {
                    $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
                }
            } else if (is_role_switched($course->id)) { // Has switched roles
                $rolename = '';
                if ($role = $DB->get_record('role', array('id'=>$USER->access['rsw'][$context->path]))) {
                    $rolename = ': '.role_get_name($role, $context);
                }
                $loggedinas = get_string('loggedinas', 'moodle', $username).$rolename;
                if ($withlinks) {
                    $url = new moodle_url('/course/switchrole.php', array('id'=>$course->id,'sesskey'=>sesskey(), 'switchrole'=>0, 'returnurl'=>$this->page->url->out_as_local_url(false)));
                    $loggedinas .= '('.html_writer::tag('a', get_string('switchrolereturn'), array('href'=>$url)).')';
                }
            } else {
                $loggedinas = $realuserinfo.get_string('loggedinas', 'moodle', $username);
                if ($withlinks) {
                    $loggedinas .= " (<a href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\">".get_string('logout').'</a>)';
                }
            }
        } else {
            $loggedinas = get_string('loggedinnot', 'moodle');
            if (!$loginpage && $withlinks) {
                $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
            }
        }

        if (isset($SESSION->justloggedin)) {
            unset($SESSION->justloggedin);
            if (!empty($CFG->displayloginfailures)) {
                if (!isguestuser()) {
                    if ($count = count_login_failures($CFG->displayloginfailures, $USER->username, $USER->lastlogin)) {
                        $loggedinas .= '&nbsp;<div class="loginfailures">';
                        if (empty($count->accounts)) {
                            $loggedinas .= get_string('failedloginattempts', '', $count);
                        } else {
                            $loggedinas .= get_string('failedloginattemptsall', '', $count);
                        }
                        if (file_exists("$CFG->dirroot/report/log/index.php") and has_capability('report/log:view', context_system::instance())) {
                            $loggedinas .= ' (<a href="'.$CFG->wwwroot.'/report/log/index.php'.
                                                 '?chooselog=1&amp;id=1&amp;modid=site_errors">'.get_string('logs').'</a>)';
                        }
                        $loggedinas .= '</div>';
                    }
                }
            }
        }

        return $loggedinas;
    }
}
?>
