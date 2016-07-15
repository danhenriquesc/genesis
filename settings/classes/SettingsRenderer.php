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

include('SettingsLoadSave.php');
include('Tab.php');

class SettingsRenderer extends SettingsLoadSave{
    protected   $imagesPath = 'images/';
    private     $themeNamePrefix = 'genesis';
    protected   $tabs = null;
    private     $currentTab = null;
    
    protected function header($savePostTo){
        GLOBAL $PAGE;
        GLOBAL $CFG;
        GLOBAL $OUTPUT;

        $PAGE->set_pagelayout('ararazu_settings');
        $PAGE->set_context(context_system::instance());
        $PAGE->set_title('Settings');
        $PAGE->set_url($CFG->wwwroot."/theme/genesis/settings/index.php");
        echo $OUTPUT->header();

        echo '<form method="POST" action="'.$savePostTo.'">';
        
        echo        '<div id="'.$this->themeNamePrefix.'SettingsHeader">';
        echo            '<img src="'.$this->imagesPath.'ararazuLogo.png" id="ararazuLogo"/>';
        echo            '<input type="submit" value="Save" id="saveOptions" class="ararazuButton ararazuButtonBlue" style="float:right;"/>';
        echo            '<a href="'.$CFG->wwwroot.'"><input type="button" value="Back" id="backOptions" class="ararazuButton ararazuButtonGreen" style="float:right;"/></a>';
        echo            '<div id="DesignerModeWarningBox">
                                <span id="DesignerMode">The Theme Designer Mode is '.(($CFG->themedesignermode!=1)?'disabled, <b><a href="'.$CFG->wwwroot.'/admin/settings.php?section=themesettings">click here</a></b> to enable, clearing the style caches and update your options.':'enabled, after edit, <b><a href="'.$CFG->wwwroot.'/admin/settings.php?section=themesettings">click here</a></b> to disable and make your Moodle faster.').'</span>';
        echo                    '<span id="DesignerModeWarning">Status: '.(($CFG->themedesignermode!=1)?'<span style="color: #555;">Disabled</span>':'<span style="color: #4E87E9;">Enabled</span>').'</span>
                        </div>';
        echo            '<input type="hidden" name="lastPage" id="lastPageInput" value="'.((isset($_GET['lp']) && $_GET['lp'] != "")?$_GET['lp']:'general').'"/>';
        echo        '</div>';
    }

    protected function footer(){
        GLOBAL $OUTPUT;

        echo '<div id="settingsContent">';

        /* Sidebar Tabs Area */
        echo    '<div id="sidebarTabsArea">';

        $cont = 0;
        foreach( $this->tabs as $key => $value){
            echo    '<div class="sidebarTabs'.(( (isset($_GET['lp']) && $_GET['lp'] == $key) || (!isset($_GET['lp']) && $key=='general'))?" tabActive":"").'" id="'.$key.'Tab"><img src="'.$this->imagesPath.'/'.$value->icon.'"/><p>'.$value->text.'</p></div>';
        }
        reset($this->tabs);

        echo    '</div>';

        $cont = 0;
        foreach( $this->tabs as $key => $value){
            echo    '<div class="settingsArea" id="'.$key.'Area" style="'.(( !((isset($_GET['lp']) && $_GET['lp'] == $key) || (!isset($_GET['lp']) && $key=='general')) )?" display:none;":"").'">';
            echo    '<h1>'.ucwords($value->text.' Settings').'</h1>';
            $tab = strtolower(str_replace(" ", "_", $value->text));
            foreach ($value->options as $key => $value) {
                $this->renderOption($value['type'], $value['id'], $value['title'], $value['description'], $value['default'], $value['options'], $value['classes'], $tab);
            }
            echo    '</div>';
        }

        echo    '<div class="clear"></div>';
        echo    '<br><br>';
        echo '</div>';

        echo $OUTPUT->footer();
    }

    protected function newTab($name,$text,$icon,$id=null,$classes=null){
        $this->tabs[$name] = new Tab($text, $icon, $id, $classes);
        $this->currentTab = $name;
    }

    protected function newOption($type = null, $id = null, $title = null, $description = null, $default = null, $options = null, $classes = null){
        if($this->currentTab == null) echo 'Please create one tab before add options';
        else{
            $this->tabs[$this->currentTab]->addOption($type, $id, $title, $description, $default, $options, $classes);
        }
    }

    protected function renderOption($type, $id, $title, $description, $default = null, $options = null, $classes = null, $tab){
        if(trim($title)!=""){
            echo '<h2>'.$title.'</h2>';
            echo '<h3>'.$description.'</h3>';
        }else{
            if(trim($description)!="")
                echo '<h4 style="margin: 8px 0;">'.$description.'</h4>';  
        }

        $function = $type."Render";
        $this->$function($id, $default, $options, $classes, $tab);
    }

    protected function radioRender($id, $default = null, $options = null, $classes = null, $tab){
        if($options != null && sizeof($options)>0){
            $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

            $load = $this->load($id);
            $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

            echo '<div class="radioOption">';
            foreach ($options as $key => $value) {
                echo '<input type="radio" name="'.$tab.'['.$id.']" value="'.$key.'" '.(($key==$loadValue)?'checked':'').' '.$class.'/><label>'.$value.'</label>';
            }
            echo '</div>';
        }
    }

    protected function imageURLRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

        echo '<div class="imageURLOption">';
        echo     '<input type="text" name="'.$tab.'['.$id.']" value="'.$loadValue.'" '.$class.'/>';
        echo     '<span '.((!isset($loadValue) || trim($loadValue) == "")?'style="display:none;"':'').'>';
        echo        '<br><br>';
        echo        '<h6>Preview</h6>';
        echo        '<img src="'.((!isset($loadValue) || trim($loadValue) == "")?'':$loadValue).'"/>';
        echo     '</span>';
        echo '</div>';
    }

    protected function textRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

        echo '<div class="textOption">';
        echo     '<input type="text" name="'.$tab.'['.$id.']" value="'.$loadValue.'" '.$class.'/>';
        echo '</div>';
    }

    protected function longtextRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

        echo '<div class="longtextOption">';
        echo     '<textarea name="'.$tab.'['.$id.']" '.$class.' id="id-'.$id.'">'.$loadValue.'</textarea>';
        echo '</div>';
    }

    protected function thumbListRender($id, $default = null, $options = null, $classes = null, $tab){
        if($options != null && sizeof($options)>0){
            $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

            $load = $this->load($id);
            $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

            echo '<div class="thumbListOption">';
            foreach ($options as $key => $value) {
                echo '<img class="thumbListItem'.(($value==$loadValue)?' selected':'').'" src="images/'.$key.'" value="'.$id.'_'.$value.'"/>';
            }
            echo '<input type="hidden" id="'.$id.'" name="'.$tab.'['.$id.']" value="'.$loadValue.'" '.$class.'/>';
            echo '</div>';
        }
    }

    protected function listRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);
        $items = json_decode($loadValue);

        echo '<div class="listOption">';
        echo    '<table '.$class.'/>';
        echo        '<thead>';
        echo            '<tr>';
        echo                '<th>#</th>';

        foreach ($options as $key => $value) {
            echo            '<th>'.$value.'</th>';
        }

        echo                '<th>Remove</th>';
        echo            '</tr>';
        echo        '</thead>';
        echo        '<tbody>';

        if((!is_array($items)) || (sizeof($items) == 0)){
            echo            '<tr>';
            echo                '<td>1</td>';

            foreach ($options as $key => $value) {
                echo            '<td><input type="text" name="'.$tab.'['.$id.'][0]['.$key.']"/></td>';
            }
            
            echo                '<td><div class="ararazuButton ararazuButtonRed listRemove" style="display:none;">Remove</div></td>';
            echo            '</tr>';        
        }else{
            $n = 1;

            foreach ($items as $k => $v) {
                echo            '<tr>';
                echo                '<td>'.($n++).'</td>';

                foreach ($options as $key => $value) {
                    if($key != 'deep')
                        echo            '<td><input type="text" name="'.$tab.'['.$id.']['.($n-2).']['.$key.']" value="'.($v->$key).'"/></td>';
                    else
                        echo            '<td>
                                            <select name="'.$tab.'['.$id.']['.($n-2).']['.$key.']" style="width: 45px;">
                                                <option value="1" '.(($v->$key==1)?'selected':'').'>1</option>
                                                <option value="2" '.(($v->$key==2)?'selected':'').'>2</option>
                                            </select>
                                        </td>';
                }
                
                echo                '<td><div class="ararazuButton ararazuButtonRed listRemove" '.((sizeof($items)==1)?'style="display:none;"':'').'>Remove</div></td>';
                echo            '</tr>';
            }

        }

        echo        '</tbody>';
        echo        '<tfoot>';
        echo            '<tr>';
        echo                '<td colspan="'.(2+sizeof($options)).'">';
        echo                    '<center>';
        echo                        '<div class="ararazuButton ararazuButtonGreen listAdd">Add</div>';
        echo                    '</center>';
        echo                '</td>';
        echo            '</tr>';
        echo        '</tfoot>';
        echo    '</table>';
        echo '</div>';   
    }

    protected function singlelistRender($id, $title, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:'');
        $items = json_decode($loadValue);

        echo '<div class="singlelistOption">';
        echo    '<table/>';
        echo        '<thead>';
        echo            '<tr>';
        echo                '<th>#</th>';
        echo                '<th>'.$title.'</th>';
        echo                '<th>Remove</th>';
        echo            '</tr>';
        echo        '</thead>';
        echo        '<tbody>';

       

        if((!is_array($items)) || (sizeof($items) == 0)){
            echo            '<tr>';
            echo                '<td>1</td>';
            echo                '<td>';
            echo                    '<select name="'.$tab.'['.$id.'][0]" '.$class.'/>';
            foreach ($options as $key => $value) {
                echo                    '<option value="'.$key.'">'.$value.'</option>';
            }
            echo                    '</select>';
            echo                '</td>';
            echo                '<td><div class="ararazuButton ararazuButtonRed listRemove" style="display:none;">Remove</div></td>';
            echo            '</tr>';        
        }else{
            $n = 1;

            foreach ($items as $k => $v) {
                echo            '<tr>';
                echo                '<td>'.($n++).'</td>';
                echo                '<td>';

                echo                    '<select name="'.$tab.'['.$id.']['.($n-2).']" '.$class.'/>';
                foreach ($options as $key => $value) {
                    echo                    '<option value="'.$key.'" '.(($key==$v)?"selected":"").'>'.$value.'</option>';
                }
                echo                    '</select>';

                echo                '</td>';            
                echo                '<td><div class="ararazuButton ararazuButtonRed listRemove" '.((sizeof($items)==1)?'style="display:none;"':'').'>Remove</div></td>';
                echo            '</tr>';
            }

        }


        echo        '</tbody>';
        echo        '<tfoot>';
        echo            '<tr>';
        echo                '<td colspan="'.(2+sizeof($options)).'">';
        echo                    '<center>';
        echo                        '<div class="ararazuButton ararazuButtonGreen listAdd">Add</div>';
        echo                    '</center>';
        echo                '</td>';
        echo            '</tr>';
        echo        '</tfoot>';
        echo    '</table>';
        echo '</div>';   
    }

    protected function separatorRender($id = null, $default = null, $option = null, $class = null, $tab = null){
        echo '<hr></hr>';
    }

    protected function titleRender($id = null, $default = null, $option = null, $class = null, $tab = null){}

    protected function selectRender($id, $default = null, $options = null, $classes = null, $tab){
        if($options != null && sizeof($options)>0){
            $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

            $load = $this->load($id);
            $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

            echo '<div class="selectOption">';
            echo    '<select name="'.$tab.'['.$id.']" '.$class.'>';
            foreach ($options as $key => $value) {
                echo    '<option value="'.$key.'" '.(($key==$loadValue)?'selected':'').'>'.$value.'</option>';
            }
            echo    '</select>';
            echo '</div>';
        }
    }

    protected function slideshowRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);
        $items = json_decode($loadValue);

        echo '<div class="slideshowOption">';
        echo    '<table '.$class.'/>';
        echo        '<tbody>';

        if((!is_array($items)) || (sizeof($items) == 0)){
            echo            '<tr>';            
            echo                '<td>';
            echo                    '<table>';
            echo                        '<thead>';
            echo                            '<tr>';
            echo                                '<td colspan="2" align="center">Slider 1</td>'; 
            echo                            '</tr>';
            echo                        '</thead>';
            echo                        '<tbody style="display: none;">';      
            echo                            '<tr>';
            echo                                '<td>';
            echo                                    '<h4>Title</h4>';
            echo                                    '<input type="text" name="'.$tab.'['.$id.'][0][title]"/>';
            echo                                '</td>';
            echo                                '<td>';
            echo                                    '<h4>Link URL</h4>'; 
            echo                                    '<input type="text" name="'.$tab.'['.$id.'][0][link]"/>';
            echo                                '</td>';               
            echo                            '</tr>';
            echo                            '<tr>';
            echo                                '<td colspan="2">';
            echo                                    '<h4>Description</h4>';
            echo                                    '<textarea name="'.$tab.'['.$id.'][0][description]"></textarea>';
            echo                                '</td>';               
            echo                            '</tr>';
            echo                            '<tr>';
            echo                                '<td colspan="2">';
            echo                                    '<h4>Image URL</h4>';
            echo                                    '<input type="text" class="slideshowImageURL" name="'.$tab.'['.$id.'][0][image]"/>';
            echo                                    '<span style="display:none;">';
            echo                                        '<br><br>';
            echo                                        '<h6>Preview</h6>';
            echo                                        '<img src=""/>';
            echo                                    '</span>';
            echo                                '</td>';               
            echo                            '</tr>';
            echo                        '</tbody>';
            echo                        '<tfoot>';
            echo                            '<tr>';
            echo                                '<td align="center" colspan="2">';
            echo                                    '<div class="ararazuButton ararazuButtonRed slideshowRemove" style="display:none;">Remove</div>';
            echo                                    '<div class="ararazuButton ararazuButtonBlue slideshowMinimize" style="margin-left:5px;">Maximize</div>';        
            echo                                '</td>';
            echo                            '</tr>';
            echo                        '</tfoot>';
            echo                    '</table>';
            echo                '</td>';
            echo            '</tr>';
        }else{
            $n = 1;

            foreach ($items as $k => $v) {
                echo            '<tr>';            
                echo                '<td>';
                echo                    '<table>';
                echo                        '<thead>';
                echo                            '<tr>';
                echo                                '<td colspan="2" align="center">Slider '.($n++).'</td>'; 
                echo                            '</tr>';
                echo                        '</thead>';
                echo                        '<tbody style="display: none;">';      
                echo                            '<tr>';
                echo                                '<td>';
                echo                                    '<h4>Title</h4>';
                echo                                    '<input type="text" name="'.$tab.'['.$id.']['.($n-2).'][title]" value="'.$v->title.'"/>';
                echo                                '</td>';
                echo                                '<td>';
                echo                                    '<h4>Link URL</h4>'; 
                echo                                    '<input type="text" name="'.$tab.'['.$id.']['.($n-2).'][link]" value="'.$v->link.'"/>';
                echo                                '</td>';               
                echo                            '</tr>';
                echo                            '<tr>';
                echo                                '<td colspan="2">';
                echo                                    '<h4>Description</h4>';
                echo                                    '<textarea name="'.$tab.'['.$id.']['.($n-2).'][description]">'.$v->description.'</textarea>';
                echo                                '</td>';               
                echo                            '</tr>';
                echo                            '<tr>';
                echo                                '<td colspan="2">';
                echo                                    '<h4>Image URL</h4>';
                echo                                    '<input type="text" class="slideshowImageURL" name="'.$tab.'['.$id.']['.($n-2).'][image]" value="'.$v->image.'"/>';
                echo                                    '<span>';
                echo                                        '<br><br>';
                echo                                        '<h6>Preview</h6>';
                echo                                        '<img src="'.$v->image.'"/>';
                echo                                    '</span>';
                echo                                '</td>';               
                echo                            '</tr>';
                echo                        '</tbody>';
                echo                        '<tfoot>';
                echo                            '<tr>';
                echo                                '<td align="center" colspan="2">';
                echo                                    '<div class="ararazuButton ararazuButtonRed slideshowRemove" '.((sizeof($items)==1)?'style="display:none;"':'').'>Remove</div>';
                echo                                    '<div class="ararazuButton ararazuButtonBlue slideshowMinimize" style="margin-left:5px;">Maximize</div>';        
                echo                                '</td>';
                echo                            '</tr>';
                echo                        '</tfoot>';
                echo                    '</table>';
                echo                '</td>';
                echo            '</tr>';
            }
        }

        echo        '</tbody>';
        echo        '<tfoot>';
        echo            '<tr>';
        echo                '<td colspan="2">';
        echo                    '<center>';
        echo                        '<div class="ararazuButton ararazuButtonGreen slideshowAdd">Add</div>';
        echo                    '</center>';
        echo                '</td>';
        echo            '</tr>';
        echo        '</tfoot>';
        echo    '</table>';
        echo '</div>';   
    }

    protected function linkboxRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?'class="'.implode(" ", $classes).'"':"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);
        $items = json_decode($loadValue);

        $faIcons = 'adjust icon-anchor icon-archive icon-asterisk icon-ban-circle icon-bar-chart icon-barcode icon-beaker icon-beer icon-bell icon-bell-alt icon-bolt icon-book icon-bookmark icon-bookmark-empty icon-briefcase icon-bug icon-building icon-bullhorn icon-bullseye icon-calendar icon-calendar-empty icon-camera icon-camera-retro icon-certificate icon-check icon-check-empty icon-check-minus icon-check-sign icon-circle icon-circle-blank icon-cloud icon-cloud-download icon-cloud-upload icon-code icon-code-fork icon-coffee icon-cog icon-cogs icon-collapse icon-collapse-alt icon-collapse-top icon-comment icon-comment-alt icon-comments icon-comments-alt icon-compass icon-credit-card icon-crop icon-dashboard icon-desktop icon-download icon-download-alt icon-edit icon-edit-sign icon-ellipsis-horizontal icon-ellipsis-vertical icon-envelope icon-envelope-alt icon-eraser icon-exchange icon-exclamation icon-exclamation-sign icon-expand icon-expand-alt icon-external-link icon-external-link-sign icon-eye-close icon-eye-open icon-facetime-video icon-female icon-fighter-jet icon-film icon-filter icon-fire icon-fire-extinguisher icon-flag icon-flag-alt icon-flag-checkered icon-folder-close icon-folder-close-alt icon-folder-open icon-folder-open-alt icon-food icon-frown icon-gamepad icon-gear icon-gears icon-gift icon-glass icon-globe icon-group icon-hdd icon-headphones icon-heart icon-heart-empty icon-home icon-inbox icon-info icon-info-sign icon-key icon-keyboard icon-laptop icon-leaf icon-legal icon-lemon icon-level-down icon-level-up icon-lightbulb icon-location-arrow icon-lock icon-magic icon-magnet icon-mail-forward icon-mail-reply icon-mail-reply-all icon-male icon-map-marker icon-meh icon-microphone icon-microphone-off icon-minus icon-minus-sign icon-minus-sign-alt icon-mobile-phone icon-money icon-moon icon-move icon-music icon-off icon-ok icon-ok-circle icon-ok-sign icon-pencil icon-phone icon-phone-sign icon-picture icon-plane icon-plus icon-plus-sign icon-plus-sign-alt icon-power-off icon-print icon-pushpin icon-puzzle-piece icon-qrcode icon-question icon-question-sign icon-quote-left icon-quote-right icon-random icon-refresh icon-remove icon-remove-circle icon-remove-sign icon-reorder icon-reply icon-reply-all icon-resize-horizontal icon-resize-vertical icon-retweet icon-road icon-rocket icon-rss icon-rss-sign icon-screenshot icon-search icon-share icon-share-alt icon-share-sign icon-shield icon-shopping-cart icon-sign-blank icon-signal icon-signin icon-signout icon-sitemap icon-smile icon-sort icon-sort-by-alphabet icon-sort-by-alphabet-alt icon-sort-by-attributes icon-sort-by-attributes-alt icon-sort-by-order icon-sort-by-order-alt icon-sort-down icon-sort-up icon-spinner icon-star icon-star-empty icon-star-half icon-star-half-empty icon-star-half-full icon-subscript icon-suitcase icon-sun icon-superscript icon-tablet icon-tag icon-tags icon-tasks icon-terminal icon-thumbs-down icon-thumbs-down-alt icon-thumbs-up icon-thumbs-up-alt icon-ticket icon-time icon-tint icon-trash icon-trophy icon-truck icon-umbrella icon-unchecked icon-unlock icon-unlock-alt icon-upload icon-upload-alt icon-user icon-volume-down icon-volume-off icon-volume-up icon-warning-sign icon-wrench icon-zoom-in icon-zoom-out icon-bitcoin icon-btc icon-cny icon-dollar icon-eur icon-euro icon-gbp icon-inr icon-jpy icon-krw icon-renminbi icon-rupee icon-usd icon-won icon-yen icon-align-center icon-align-justify icon-align-left icon-align-right icon-bold icon-columns icon-copy icon-cut icon-eraser icon-file icon-file-alt icon-file-text icon-file-text-alt icon-font icon-indent-left icon-indent-right icon-italic icon-link icon-list icon-list-alt icon-list-ol icon-list-ul icon-list-ul icon-paper-clip icon-paperclip (alias) icon-paste icon-repeat icon-rotate-left (alias) icon-rotate-right (alias) icon-save icon-strikethrough icon-table icon-text-height icon-text-width icon-th icon-th-large icon-th-list icon-underline icon-undo icon-unlink icon-angle-down icon-angle-left icon-angle-right icon-angle-up icon-arrow-down icon-arrow-left icon-arrow-right icon-arrow-up icon-caret-down icon-caret-left icon-caret-right icon-caret-up icon-chevron-down icon-chevron-left icon-chevron-right icon-chevron-sign-down icon-chevron-sign-left icon-chevron-sign-right icon-chevron-sign-up icon-chevron-up icon-circle-arrow-down icon-circle-arrow-left icon-circle-arrow-right icon-circle-arrow-up icon-double-angle-down icon-double-angle-left icon-double-angle-right icon-double-angle-up icon-hand-down icon-hand-left icon-hand-right icon-hand-up icon-long-arrow-down icon-long-arrow-left icon-long-arrow-right icon-long-arrow-up icon-backward icon-eject icon-fast-backward icon-fast-forward icon-forward icon-fullscreen icon-pause icon-play icon-play-circle icon-play-sign icon-resize-full icon-resize-small icon-step-backward icon-step-forward icon-stop icon-youtube-play icon-adn icon-android icon-apple icon-bitbucket icon-bitbucket-sign icon-bitcoin icon-btc icon-css3 icon-dribbble icon-dropbox icon-facebook icon-facebook-sign icon-flickr icon-foursquare icon-github icon-github-alt icon-github-sign icon-gittip icon-google-plus icon-google-plus-sign icon-html5 icon-instagram icon-linkedin icon-linkedin-sign icon-linux icon-maxcdn icon-pinterest icon-pinterest-sign icon-renren icon-skype icon-stackexchange icon-trello icon-tumblr icon-tumblr-sign icon-twitter icon-twitter-sign icon-vk icon-weibo icon-windows icon-xing icon-xing-sign icon-youtube icon-youtube-play icon-youtube-sign icon-ambulance icon-h-sign icon-hospital icon-medkit icon-plus-sign-alt icon-stethoscope icon-user-md';
        $tmpSelectOptions = explode(" icon-", $faIcons);
        $selectOptions = array();

        sort($tmpSelectOptions);

        for($i=0; $i<sizeof($tmpSelectOptions); $i++){
            $tmpValue = ucfirst(str_replace('-', ' ', $tmpSelectOptions[$i]));
            $selectOptions['fa-'.$tmpSelectOptions[$i]] = $tmpValue;
        }


        echo '<div class="linkboxOption">';
        echo    '<table '.$class.'/>';
        echo        '<tbody>';


        if((!is_array($items)) || (sizeof($items) == 0)){
            echo            '<tr>';
            echo                '<td>';
            echo                    '<table>';
            echo                        '<thead>';
            echo                            '<tr>';
            echo                                '<td colspan="3" align="center">Link Box 1</td>'; 
            echo                            '</tr>';
            echo                        '</thead>';
            echo                        '<tbody style="display: none;">';      
            echo                            '<tr>';
            echo                                '<td>';
            echo                                    '<h4>Title</h4>';
            echo                                    '<input type="text" name="'.$tab.'['.$id.'][0][title]"/>';
            echo                                '</td>';
            echo                                '<td>';
            echo                                    '<h4>Link URL</h4>'; 
            echo                                    '<input type="text" name="'.$tab.'['.$id.'][0][link]"/>';
            echo                                '</td>';               
            echo                                '<td>';
            echo                                    '<h4>Image</h4>'; 
            echo                                    '<select name="'.$tab.'['.$id.'][0][icon]">';

            foreach ($selectOptions as $key => $value) {
                echo '<option value="'.$key.'">'.$value.'</option>';
            }

            echo                                    '</select>';
            echo                                '</td>';
            echo                            '</tr>';
            echo                            '<tr>';
            echo                                '<td colspan="3">';
            echo                                    '<h4>Description</h4>';
            echo                                    '<textarea name="'.$tab.'['.$id.'][0][text]"></textarea>';
            echo                                '</td>';               
            echo                            '</tr>';
            echo                        '</tbody>';
            echo                        '<tfoot>';
            echo                            '<tr>';
            echo                                '<td align="center" colspan="3">';
            echo                                    '<div class="ararazuButton ararazuButtonRed linkboxRemove" style="display:none;">Remove</div>';
            echo                                    '<div class="ararazuButton ararazuButtonBlue linkboxMinimize" style="margin-left:5px;">Maximize</div>';        
            echo                                '</td>';
            echo                            '</tr>';
            echo                        '</tfoot>';
            echo                    '</table>';
            echo                '</td>';
            echo            '</tr>';
        }else{
            $n = 1;

            foreach ($items as $k => $v) {
                echo            '<tr>';
                echo                '<td>';
                echo                    '<table>';
                echo                        '<thead>';
                echo                            '<tr>';
                echo                                '<td colspan="3" align="center">Link Box '.($n++).'</td>'; 
                echo                            '</tr>';
                echo                        '</thead>';
                echo                        '<tbody style="display: none;">';      
                echo                            '<tr>';
                echo                                '<td>';
                echo                                    '<h4>Title</h4>';
                echo                                    '<input type="text" name="'.$tab.'['.$id.']['.($n-2).'][title]" value="'.$v->title.'"/>';
                echo                                '</td>';
                echo                                '<td>';
                echo                                    '<h4>Link URL</h4>'; 
                echo                                    '<input type="text" name="'.$tab.'['.$id.']['.($n-2).'][link]" value="'.$v->link.'"/>';
                echo                                '</td>';               
                echo                                '<td>';
                echo                                    '<h4>Image</h4>'; 
                echo                                    '<select name="'.$tab.'['.$id.']['.($n-2).'][icon]">';
                
                foreach ($selectOptions as $key => $value) {
                    echo '<option value="'.$key.'" '.(($key==$v->icon)?'selected':'').'>'.$value.'</option>';
                }

                echo                                    '</select>';
                echo                                '</td>';
                echo                            '</tr>';
                echo                            '<tr>';
                echo                                '<td colspan="3">';
                echo                                    '<h4>Description</h4>';
                echo                                    '<textarea name="'.$tab.'['.$id.']['.($n-2).'][text]">'.$v->text.'</textarea>';
                echo                                '</td>';               
                echo                            '</tr>';
                echo                        '</tbody>';
                echo                        '<tfoot>';
                echo                            '<tr>';
                echo                                '<td align="center" colspan="3">';
                echo                                    '<div class="ararazuButton ararazuButtonRed linkboxRemove" '.((sizeof($items)==1)?'style="display:none;"':'').'>Remove</div>';
                echo                                    '<div class="ararazuButton ararazuButtonBlue linkboxMinimize" style="margin-left:5px;">Maximize</div>';        
                echo                                '</td>';
                echo                            '</tr>';
                echo                        '</tfoot>';
                echo                    '</table>';
                echo                '</td>';
                echo            '</tr>';
            }
        }


        echo        '</tbody>';
        echo        '<tfoot>';
        echo            '<tr>';
        echo                '<td colspan="3">';
        echo                    '<center>';
        echo                        '<div class="ararazuButton ararazuButtonGreen linkboxAdd">Add</div>';
        echo                    '</center>';
        echo                '</td>';
        echo            '</tr>';
        echo        '</tfoot>';
        echo    '</table>';
        echo '</div>';   
    }

    protected function colorpickerRender($id, $default = null, $options = null, $classes = null, $tab){
        $class = (is_array($classes)?implode(" ", $classes):"");

        $load = $this->load($id);
        $loadValue = ((isset($load) && trim($load)!="")?$load:$default);

        echo '<div class="colorpickerOption '.$class.'">';
            echo '<div id="colorSelector_'.$id.'" class="colorSelector"><div style="background-color: '.$loadValue.'"></div></div>';
            echo '<input type="hidden" value="'.$loadValue.'" name="'.$tab.'['.$id.']" />';
            echo '<script type="text/javascript">

                        (function($){
                            var initLayout = function() {
                                $("#colorSelector_'.$id.'").ColorPicker({
                                    color: "'.$loadValue.'",
                                    onHide: function (colpkr) {
                                        $(colpkr).fadeOut(500);
                                        return false;
                                    },
                                    onChange: function (hsb, hex, rgb) {
                                        $("#colorSelector_'.$id.' div").css("backgroundColor", "#" + hex);
                                        $("#colorSelector_'.$id.'").parent().find("input").val("#" + hex);
                                    }
                                });
                            };
                            
                            var showTab = function(e) {
                                var tabIndex = $("ul.navigationTabs a")
                                                    .removeClass("active")
                                                    .index(this);
                                $(this)
                                    .addClass("active")
                                    .blur();
                                $("div.tab")
                                    .hide()
                                        .eq(tabIndex)
                                        .show();
                            };
                            
                            EYE.register(initLayout, "init");
                        })(jQuery)

                  </script>';
        echo '</div>';
    }
}

?>
