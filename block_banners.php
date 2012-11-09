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
 * Form for editing banners block instances.
 *
 * @package   block_banners
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.banners GNU GPL v3 or later
 */

class block_banners extends block_base {

    function init() {
        global $PAGE;
        $this->title = get_string('pluginname', 'block_banners');
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : ''; 
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $PAGE,$CFG;
        require_once($CFG->libdir . '/filelib.php');
        $PAGE->requires->js('/blocks/banners/banners.js'); 
        $PAGE->requires->js_init_call('animatebanners', array($this->instance->id,$this->config));            
        if ($this->content !== NULL) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text = $this->genBannerFrontend();
        return $this->content;
    }
    
    function genBannerFrontend(){
    	global $CFG,$DB,$PAGE,$COURSE,$FULLSCRIPT;
    	require_once(dirname(__FILE__).'/lib.php');
    	$return_url = $FULLSCRIPT;
 	           
        $context = get_context_instance(CONTEXT_BLOCK, $this->instance->id);
        $admin_context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        
        // everyone has permissions or is it a course editor?
        $can_add_banner = $this->config->config_permission>0 
                       || has_capability('moodle/block:edit', $context, $_SESSION['USER']->id, false) || has_capability('moodle/site:config', $admin_context);
        $addlink = '<a href="'.$CFG->wwwroot.'/blocks/banners/add.php?id=' . $this->instance->id . '&returnurl=' . $return_url .'">
                    <img src="'.$CFG->wwwroot.'/blocks/banners/images/add.png" title="Manage Banner"></a>';
        if($file_arr = get_banner_images($this->context->id)){
            $h = $this->config->height;
            $w = $this->config->width;
            if($can_add_banner || $this->con){
                $add='<span style="right:-20px;top:-22px;z-index:10;position:relative;float:right;"><a href="'.$CFG->wwwroot.'/blocks/banners/add.php?id=' . $this->instance->id . '&returnurl=' . $return_url .'">' . $addlink . '</span>';
            }
        
    	    $pause = '<span style="left:-20px;top:-22px;z-index:10;position:relative;float:left;"><a href="javascript:void(0)"><img src="'.$CFG->wwwroot.'/blocks/banners/images/pause.png" id="pause_banner_'.$this->instance->id.'"></a></span>';
            $left = '<span style="top:-' . $h . 'px;z-index:10;position:relative;float:left;"><a href="javascript:void(0)"><img src="'.$CFG->wwwroot.'/blocks/banners/images/left.png" id="left_banner_'.$this->instance->id.'"></a></span>';
            $right = '<span style="top:-' . $h . 'px;z-index:10;position:relative;float:right;"><a href="javascript:void(0)"><img src="'.$CFG->wwwroot.'/blocks/banners/images/right.png" id="right_banner_'.$this->instance->id.'"></a></span>';
            
            for($i=0;$i<sizeof($file_arr);$i++){
    		    if(bannerWithinShowPeriod($file_arr[$i][3],$this->config->maxday)){
    			    $banner_url = getBannerURL($file_arr[$i][0]);
    			    
    			    $banner='<li>';
    			    if($banner_url!='')
    				    $banner.='<a href="'.$banner_url.'">';
    			    $banner.='<img src="'.$file_arr[$i][1].'" />';
    			    if($banner_url!='')
    				    $banner.='</a>';
    			    $banner.='</li>';
                    $banners[]=$banner;
    		    }
    	    }
            $banners[]=$banners[0];			    
    	    $speed = $this->config->speed==''?1000:$this->config->speed*1000;
    	    $element_id = 'container_'.$this->instance->id;
    	    $html = '<div style="margin:0px auto;padding:0px;overflow:hidden;width:' . $this->config->width . 'px;height:' . ($this->config->height+2) . 'px">' .
                    '<div style="border:0px;height:' . $this->config->height . 'px;width:' . $this->config->width . 'px;overflow:hidden;margin:auto;z-index:0;visibility:hidden" id="'.$element_id.'" >
				    <ul id="banner_ul" >
				    '.implode('',$banners).'
				    </ul></div></div>' . $left . $right . $pause . $add ;
        }else{
           // no banners - just supply post link
            if($can_add_banner){
                 $html = '<div style="min-height:40px;margin:0px auto;padding:0px;overflow:hidden;">' 
                    . $addlink .'</div>';
            } 
        }

    	return $html;
    }


    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $DB;

        $config = clone($data);
        parent::instance_config_save($config, $nolongerused);
    }

    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_banners');
        return true;
    }

    public function instance_can_be_docked() {
    	return false;
    }
}
