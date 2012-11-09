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
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.banners GNU GPL v3 or later
 */

/**
 * Form for editing banners block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.banners GNU GPL v3 or later
 */
class block_banners_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Fields for editing banners block title and contents.
              
        $mform->addElement('text', 'config_width', get_string('width', 'block_banners'));
        $mform->setType('config_width', PARAM_INT); 
        $mform->setDefault('config_width', 600);
        
        $mform->addElement('text', 'config_height', get_string('height', 'block_banners'));
        $mform->setType('config_height', PARAM_INT); 
        $mform->setDefault('config_height', 120);
        
        $mform->addElement('text', 'config_maxday', get_string('maxday', 'block_banners'));
        $mform->setType('config_maxday', PARAM_INT); 
        $mform->setDefault('config_maxday', 10);
        
        $mform->addElement('select', 'config_permission', get_string('permission_2_upload_banner', 'block_banners'), array(0=>'Editors',1=>'All'),$attributes);
		$mform->setType('config_permission', PARAM_INT); 
        $mform->setDefault('config_permission', 0);
        
        $mform->addElement('text', 'config_speed', get_string('speed_in_second', 'block_banners'), $attributes);
        $mform->setType('config_speed', PARAM_INT); 
        $mform->setDefault('config_speed', 5);
        
        $mform->addElement('text', 'config_title', get_string('title', 'block_banners'));
        $mform->setType('config_title', PARAM_TEXT); 
        $mform->setDefault('config_title', '');
        
        
    }
    function set_data($defaults) {
        parent::set_data($defaults);
    }

}
