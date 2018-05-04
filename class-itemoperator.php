<?php
/**
 * For operating items in functions-custom-0.php and functions-custom-1.php
 * $hui_item_content: a array of the item's info
 * return TRUE or FALSE
 */
class hui_item_operator{
    var $hui_target_file_name = 'custom/functions-custom-0.php';

    public function set_target($hui_functions_file_name){
        $this -> $hui_target_file_name = 'custom/'.$hui_functions_file_name;
        return true;
    }

    public function add_item($hui_item_content){
        //...
    }

    public function edit_item($hui_item_id, $hui_item_content){
        //...
    }

    public function delete_item($hui_item_id){
        //...
    }

    public function delete_all_items(){
        //...
    }

    public function disable_item($hui_item_id){
        //...
    }

    public function disable_all_items(){
        //...
    }

    public function enable_item($hui_item_id){
        //...
    }

    public function enable_all_items(){
        //...
    }

    /**
     * Create a buckup of functions-custom-0.php and functions-custom-1.php when the plugin is deactivated
     * Create a copy in ../../../hui-backup/custom/
     * Will be deleted when the plugin is activated or in the process of uninstallation
     */
    public function create_backup(){
        //...
    }

    /**
     * Remove the buckup of functions-custom-0.php and functions-custom-1.php in ../../../hui-backup/custom/ when the plugin is in the process of uninstallation
     */
    public function remove_backup(){
        //...
    }

     /**
     * Move the buckup of functions-custom-0.php and functions-custom-1.php from ../../../hui-backup/custom/ to ./custom/ when the plugin is activated
     */
    public function cover_backup(){
        //...
    }
}
?>