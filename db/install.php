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
	 
	function xmldb_theme_genesis_install() {
		/* Setting default settings */
    	
		/* Best Moodle Settings for Genesis */
		set_config('defaulthomepage','1');
		set_config('frontpage','');
		set_config('frontpageloggedin','');
		set_config('courseswithsummarieslimit','500');

	    /* General */
		set_config('themecolor','orange','theme_genesis');
		set_config('layoutStyle','wide','theme_genesis');
		set_config('generalsidebar','side-pre','theme_genesis');
		set_config('faviconurl','','theme_genesis');
		set_config('breadcrumb','1','theme_genesis');
		set_config('font','oxygen','theme_genesis');
		set_config('showRegisterInstructions','1','theme_genesis');
		set_config('shibbolethLogin','0','theme_genesis');
		set_config('guestLogin','0','theme_genesis');
		set_config('customColorScheme1','#FFFFFF','theme_genesis');
		set_config('customColorScheme2','#FFFFFF','theme_genesis');
		set_config('customColorScheme3','#FFFFFF','theme_genesis');
		set_config('customColorScheme4','#FFFFFF','theme_genesis');
		set_config('editPageButton','1','theme_genesis');
		set_config('googleAnalytics','','theme_genesis');
		set_config('customCSS','','theme_genesis');

	    /* Frontpage */
		set_config('frontpagesidebar','','theme_genesis');
		set_config('featuredcourses','','theme_genesis');
		set_config('showfeaturedcourses','0','theme_genesis');
		set_config('courseName','fullname','theme_genesis');

	    /* Linkbox */
	   	set_config('linkboxdata','[{"title":"Linkbox 1","link":"#","icon":"fa-fire","text":"Pellentesque enim tellus, consectetur id erat auctor, rhoncus dapibus nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis condimentum cursus nibh, sed tincidunt sem gravida congue."},{"title":"Linkbox 2","link":"#","icon":"fa-globe","text":"Pellentesque enim tellus, consectetur id erat auctor, rhoncus dapibus nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis condimentum cursus nibh, sed tincidunt sem gravida congue."},{"title":"Linkbox 3","link":"#","icon":"fa-legal","text":"Pellentesque enim tellus, consectetur id erat auctor, rhoncus dapibus nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis condimentum cursus nibh, sed tincidunt sem gravida congue."},{"title":"Linkbox 4","link":"#","icon":"fa-heart","text":"Pellentesque enim tellus, consectetur id erat auctor, rhoncus dapibus nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis condimentum cursus nibh, sed tincidunt sem gravida congue."}]','theme_genesis');
	    set_config('showlinkboxes','1','theme_genesis');    
	    
	    /* Footer */
	    set_config('copyright','All rights reserved  | Ararazu ®','theme_genesis'); 
		set_config('footermodule1','aboutus','theme_genesis');     
	    set_config('footermodule2','links','theme_genesis');     
	    set_config('footermodule3','contactinfo','theme_genesis');     
	    
	    /* Header */
	    set_config('headerType','1','theme_genesis');     
		set_config('logourl','','theme_genesis');
	    set_config('logoHeight','70','theme_genesis');
		set_config('headerPadding','25','theme_genesis');
		set_config('menuMarginTop','3','theme_genesis');
		set_config('registerLink','0','theme_genesis');
	    set_config('loggedAs','0','theme_genesis');
		set_config('menudata','[{"text":"My","link":"http:\/\/localhost\/moodle253\/my\/","deep":"1"},{"text":"My Homepage 2","link":"#","deep":"2"},{"text":"Courses","link":"http:\/\/localhost\/moodle253\/course","deep":"1"},{"text":"Course A","link":"http:\/\/www.google.com","deep":"2"},{"text":"Course B","link":"http:\/\/www.facebook.com","deep":"2"},{"text":"Course C","link":"http:\/\/www.pinterest.com","deep":"2"},{"text":"Typography","link":"#","deep":"1"},{"text":"Documentation","link":"#","deep":"1"},{"text":"Installation","link":"#","deep":"2"},{"text":"Features","link":"#","deep":"2"}]','theme_genesis');     
	    
	    /* Social Icons */
	    set_config('headersocialicon','1','theme_genesis');    
	    set_config('footersocialicon','1','theme_genesis');    
	    
	    /* Slider */
	    set_config('slidermode','slideshow','theme_genesis');    
		set_config('sliderplugin','plume','theme_genesis');    
		set_config('sliderspeed','6000','theme_genesis');    
		set_config('sliderheight','400','theme_genesis');    
		set_config('slidermode','slideshow','theme_genesis');    
		set_config('sliderpattern','waves','theme_genesis'); 
		set_config('sliderinsidebackground','','theme_genesis'); 
	    set_config('slideshowdata','[{"title":"Three Colors","link":"#","description":"Three beautiful color schemes for your Moodle.\r\nClean and efficient.","image":"http:\/\/mediabox.ararazu.com\/images\/themeforest\/portal\/preview_slide_4.jpg"},{"title":"Footer Modules","link":"#","description":"Exclusive footer module resources.\r\nThree areas and a lot of modules.","image":"http:\/\/mediabox.ararazu.com\/images\/themeforest\/portal\/preview_slide_1.jpg"},{"title":"Login Page","link":"#","description":"An modern and exclusive login page. The Moodle as you never saw.","image":"http:\/\/mediabox.ararazu.com\/images\/themeforest\/portal\/preview_slide_3.jpg"}]','theme_genesis');    
	    
	    /* Footer modules */
	    set_config('footermod_aboutus_whitelogo','','theme_genesis');    
	    set_config('footermod_aboutus_text','Donec vitae eros sit amet nibh fringilla hendrerit non at odio. Sed eu lacus hendrerit, venenatis elit ac, mollis massa. Sed nec enim ac justo feugiat tincidunt vitae sed felis. Pellentesque tincidunt viverra justo, eget posuere sem facilisis sit amet.','theme_genesis');        
		set_config('footermod_image_title','Image Title','theme_genesis');    
		set_config('footermod_image_url','','theme_genesis');    
		set_config('footermod_links','[{"text":"Facebook - Share this!","link":"https:\/\/www.facebook.com\/"},{"text":"Google","link":"https:\/\/www.google.com.br\/"},{"text":"Twitter - Follow us!","link":"https:\/\/twitter.com\/"},{"text":"Ararazu","link":"http:\/\/themeforest.net\/user\/ararazu"}]','theme_genesis');
		set_config('footermod_contact_address','Address 42','theme_genesis');    
		set_config('footermod_contact_city','Rio - Brazil','theme_genesis');    
		set_config('footermod_contact_phone','+99 (99) 9999-9999','theme_genesis');    
		set_config('footermod_contact_mail','email@email.com','theme_genesis');    
	    
	    /* Social Icons */
	    set_config('social_rss','','theme_genesis');    
	    set_config('social_twitter','','theme_genesis');    
	    set_config('social_dribbble','','theme_genesis');    
		set_config('social_vimeo','','theme_genesis');  
	    set_config('social_facebook','','theme_genesis');
	    set_config('social_youtube','','theme_genesis');
	    set_config('social_flickr','','theme_genesis');
	    set_config('social_gplus','','theme_genesis');
	    set_config('social_linkedin','','theme_genesis');
	    set_config('social_tumblr','','theme_genesis');
	    set_config('social_wordpress','','theme_genesis');
	    set_config('social_pinterest','','theme_genesis');

	    return true;
	}
?>