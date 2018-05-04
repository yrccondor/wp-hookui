<?php
/**
 * This file was prepared for uninstallation
 */
if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

//Delete all options. Goodbye.
delete_option('hui_hash');
delete_option('hui_options');
delete_option('hui_init');
delete_option('hui_version');

//Remove backup
$hui_item_operator -> set_target('functions-custom-0.php');
$hui_item_operator -> remove_backup();
$hui_item_operator -> set_target('functions-custom-1.php');
$hui_item_operator -> remove_backup();
?>