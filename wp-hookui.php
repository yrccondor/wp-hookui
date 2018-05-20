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
 * Init
 */
include('class-itemoperator.php');
$hui_item_operator_0 = new hui_item_operator('functions-custom-0.php');
$hui_item_operator_1 = new hui_item_operator('functions-custom-1.php');

/**
 * Import functions
 */
include('hui-functions.php');

/**
 * For activation && deactivation
 */
register_activation_hook(__FILE__, 'hui_init');
register_deactivation_hook(__FILE__, 'hui_disable');

function hui_init(){
    if(version_compare(get_bloginfo('version'), '4.4', '<')){
        deactivate_plugins(basename(__FILE__)); //disable
    }else{
        if(!get_option('hui_init')){
            $hui_file_hash = array(
                'functions-custom-0.php' => md5_file('custom/functions-custom-0.php'),
                'functions-custom-1.php' => md5_file('custom/functions-custom-1.php'),
            );
            update_option('hui_hash', $hui_file_hash);
            $hui_init_options = array(
                'target_file' => 'functions-custom-0.php',
                'file_backup' => 'false'
            );
            update_option('hui_options', $hui_init_options);
            include('version.php');
            update_option('hui_version', $hui_version);
            update_option('hui_init', md5(date('Y-m-d H:i:s')));
        }else{
            cover_backup();
            $hui_item_operator_0 -> enable_all_items();
            $hui_item_operator_1 -> enable_all_items();
            include('version.php');
            if(!get_option('hui_version') || get_option('hui_version')['version'] != $hui_version['version']){
                update_option('hui_version', $hui_version); //update version
            }
        }
    }
    
}

function hui_disable(){
    $hui_item_operator_0 -> disable_all_items();
    $hui_item_operator_1 -> disable_all_items();
    create_backup();
    $hui_backup = get_option('hui_options');
    $hui_backup['file_backup'] = 'true';
    update_option('hui_options', $hui_backup);
}

/**
 * Set menus
 */
include('hui-menus.php');

/**
 * Import main file
 */
$hui_target_file = get_option('hui_options');
if($hui_target_file['target_file'] != ''){
    include('custom/'.$hui_target_file);
}else{
    include('custom/functions-custom-0.php');
    $hui_target_file['target_file'] = 'functions-custom-0.php';
    update_option('hui_options', $hui_target_file); //repair
}
?>