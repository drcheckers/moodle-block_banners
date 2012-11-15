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
 * minimalistic edit form
 *
 * @package   block_private_files
 * @copyright 2010 Petr Skoda (http://skodak.org)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class banner_upload_form extends moodleform {
    function definition() {
        $mform = $this->_form;

        $data           = $this->_customdata['data'];
        
        $filemanager_options = array();
        $filemanager_options['return_types'] = 3;
        $filemanager_options['accepted_types'] = array('.jpg','.jpeg','.gif','.png');
        $filemanager_options['maxbytes'] = 0;
        $filemanager_options['maxfiles'] = 1;
        $filemanager_options['mainfile'] = false;        
        
        $mform->addElement('html', html_writer::tag('h3',get_string('bannerformat','block_banners')));
        $mform->addElement('html', html_writer::tag('p',get_string('width','block_banners') . ': ' . $this->_customdata['config']->width . 'px x '. get_string('height','block_banners') . ': ' . $this->_customdata['config']->height . 'px'));
        $mform->addElement('html', html_writer::tag('p',get_string('fileformat','block_banners') . ': ' . implode(',',$filemanager_options['accepted_types']) ));
        $mform->addElement('filepicker', 'files', get_string('uploadafile'), null, $filemanager_options);
        $mform->addElement('date_selector', 'timeavailablefrom', get_string('startdate','block_banners'));
        
        $numberofdays = array();
        for($i = 1; $i <= $this->_customdata['config']->maxday; $i++) {
            $numberofdays[$i] = $i;
        }
        
        $mform->addElement('select', 'banner_days', get_string('bannerdays','block_banners'), $numberofdays);
        $mform->setDefault('banner_days', floor($this->_customdata['config']->maxday/2));
        $mform->addElement('text', 'urllink', get_string('urllink','block_banners'), array('size'=>50));
        $mform->setDefault('urllink', '');

        $mform->addElement('hidden', 'id', $data->block_id);
        $mform->addElement('hidden', 'courseid', $data->courseid);
        $mform->addElement('hidden', 'maxday', $this->_customdata['config']->maxday);
        $mform->addElement('hidden', 'height', $this->_customdata['config']->height);
        $mform->addElement('hidden', 'width', $this->_customdata['config']->width);
        $mform->addElement('hidden', 'returnurl', $data->returnurl);
        $this->add_action_buttons(true, get_string('savechanges'));

        $this->set_data($data);
    }
    
    function validation($data, $files) {
        global $CFG;
        require_once('lib.php');
        $errors = array();
        /*$draftitemid = $data['files'];
        $fileinfo = file_get_draft_area_info($draftitemid);
        
        if ($fileinfo['filesize'] > $CFG->userquota) {
            $errors['files_filemanager'] = get_string('userquotalimit', 'error');
        } */

        return $errors;
    }
}
