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
 * @copyright 2010 Petr Skoda (http://skodak.org)
 * @license   http://www.gnu.org/copyleft/gpl.banners GNU GPL v3 or later
 */

define('TEACHER_PERMISSION',1);
define('STUDENT_PERMISSION',2);
define('TEACHER_N_STUDENT_PERMISSION',3);
function block_banners_pluginfile($course, $birecord_or_cm, $context, $filearea, $args, $forcedownload) {
    global $SCRIPT;
    if ($context->contextlevel != CONTEXT_BLOCK) {
        send_file_not_found();
    }

    require_course_login($course);

    if ($filearea !== 'content') {
        send_file_not_found();
    }

    $fs = get_file_storage();
    $filename = array_pop($args);
    $itemid = array_pop($args);
    $filepath = $args ? '/'.implode('/', $args).'/' : '/';

    if (!$file = $fs->get_file($context->id, 'block_banners', 'content', $itemid, $filepath, $filename) or $file->is_directory()) {
        send_file_not_found();
    }

    if ($parentcontext = get_context_instance_by_id($birecord_or_cm->parentcontextid)) {
        if ($parentcontext->contextlevel == CONTEXT_USER) {
            // force download on all personal pages including /my/
            //because we do not have reliable way to find out from where this is used
            $forcedownload = true;
        }
    } else {
        // weird, there should be parent context, better force dowload then
        $forcedownload = true;
    }

    session_get_instance()->write_close();
    send_stored_file($file, 60*60, 0, $forcedownload);
}

/**
 * Perform global search replace such as when migrating site to new URL.
 * @param  $search
 * @param  $replace
 * @return void
 */
function block_banners_global_db_replace($search, $replace) {
    global $DB;

    $instances = $DB->get_recordset('block_instances', array('blockname' => 'banners'));
    foreach ($instances as $instance) {
        // TODO: intentionally hardcoded until MDL-26800 is fixed
        $config = unserialize(base64_decode($instance->configdata));
        if (isset($config->text) and is_string($config->text)) {
            $config->text = str_replace($search, $replace, $config->text);
            $DB->set_field('block_instances', 'configdata', base64_encode(serialize($config)), array('id' => $instance->id));
        }
    }
    $instances->close();
}

function get_banner_images($contextid){
	global $DB,$COURSE,$CFG;
	$date = date("Ymd");
	$sql = "SELECT id, contextid,component,filearea,itemid,filename, timecreated 
            FROM {files} t0 inner join {block_banners} t1 on t0.id=t1.fileid 
            WHERE timeinput<=$date and $date<=displayuntil 
            and contextid=$contextid AND filesize>0 ORDER BY rand()";
	
	$file = array();
    if ($sections = $DB->get_recordset_sql($sql)) {
    	foreach($sections as $section){
    		$path = $CFG->wwwroot."/pluginfile.php/".$section->contextid."/".$section->component."/".$section->filearea."/".$section->itemid."/".$section->filename;
    		$file[] = array($section->id,$path,$section->filename,$section->timecreated);
		}
	}
	return $file;
}
 
function get_image_name_by_id($id){
	global $DB,$CFG;
	$sql = "SELECT filename FROM ".$CFG->prefix."files WHERE id = ".$id;
	$obj = $DB->get_fieldset_sql($sql);
	return $obj[0];
}				                
				        
function bannerWithinShowPeriod($banner_create_time,$maxday){
	
	if($maxday==0)
	return false;
	$diff = strtotime("now") - $banner_create_time;
	
	$day_diff = intval((floor($diff/86400)));
	
	if($maxday>=$day_diff)
	return true;

}
  
function getBannerURL($fileid){
	global $DB;
	$banner_url_obj = $DB->get_fieldset_sql("SELECT url FROM {block_banners} WHERE fileid = ".$fileid);
	return $banner_url_obj[0];
}
			
