<?php
/**
* This file was prepared for uninstallation
**/
if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}
//Delet all options. Goodbye.
delete_option('hui_options');
delete_option('hui_init');
//A new story...
?>