<?php
/**
 * For querying items in functions-custom-0.php and functions-custom-1.php
 */
class hui_item_querist{
    var $hui_target_file_name = 'custom/functions-custom-0.php';

    public function set_target($hui_functions_file_name){
        $this -> $hui_target_file_name = 'custom/'.$hui_functions_file_name;
    }

    /**
     * Search a item by key
     * $hui_item_key: A array of the item's info
     * return the ID of the first matched item or FALSE
     */
    public function search_item($hui_item_key){
        //...
    }

    /**
     * Get infos about a item
     * return a array of the item's info or FALSE
     */
    public function get_item_info($hui_item_id){
        //...
    }

    /**
     * List important info of all items
     * return a array of all items' important info or FALSE
     */
    public function list_item(){
        //...
    }
}
?>