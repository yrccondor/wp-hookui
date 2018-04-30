<?php
/*
Plugin Name: WPHookUI
Plugin URI: https://hui.flyhigher.top
Version: 1.0.0
Author: Axton
Author URI: https://flyhigher.top
License: GPLv3
*/
/* Copyright 2018 Axton
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version  of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
* For activation && deactivation
**/
register_activation_hook(__FILE__, 'hui_init');
register_deactivation_hook(__FILE__, 'hui_disable');

function hui_init(){
    if(version_compare(get_bloginfo('version'), '4.4', '<')){
        deactivate_plugins(basename(__FILE__)); //disable
    }
    if(!get_option('hui_init')){
        $hui_init_options = array(
            //A new story...
        );
        update_option('hui_options', $hui_init_options);
        update_option('hui_init', md5(date('Y H:i:s')));
    }
    //A new story...
}

function hui_disable(){
    //A new story...
}
?>