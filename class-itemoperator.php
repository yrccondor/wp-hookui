<?php
/**
 * For operating items in functions-custom-0.php and functions-custom-1.php
 * $hui_item_content: an array of the item's info
 * return TRUE or FALSE
 */
class hui_item_operator{
    var $hui_target_file_name;

    function __construct($hui_functions_file_name){
        $this -> hui_target_file_name = 'custom/'.$hui_functions_file_name;
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

    private function copy_dir($hui_before, $hui_after){
        $src = $hui_before;
        $dst = $hui_after;

        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ($file = readdir($dir))){ 
            if(($file != '.') && $file != '..')){ 
                if(is_dir($src.'/'.$file)){ 
                    recurse_copy($src.'/'.$file,$dst. '/'.$file); 
                } 
                else { 
                    copy($src.'/'.$file,$dst.'/'.$file); 
                } 
            } 
        } 
        closedir($dir);
        return true;
    }

    private function delete_dir($hui_path){
        $dir = $hui_path;

        $handle = @opendir($dir);
        while(($file = readdir($handle)) !== false){   
            if($file != '.' && $file != '..'){   
                $dir = $dir.'/'.$file;
                unlink($dir);
            }
        }
        closedir($handle);
        return rmdir($dir);
    }

    /**
     * Create a buckup of functions-custom-0.php and functions-custom-1.php when the plugin is deactivated
     * Create a copy in ../../../hui-backup/custom/
     * Will be deleted when the plugin is activated or in the process of uninstallation
     * Ignore $target_file_name
     */
    public function create_backup(){
        return $this -> copy_dir('custom/', '../../../hui-backup/custom/');
    }

    /**
     * Remove the buckup of functions-custom-0.php and functions-custom-1.php in ../../../hui-backup/custom/ when the plugin is in the process of uninstallation
     * Ignore $target_file_name
     */
    public function remove_backup(){
        return $this -> delete_dir('../../../hui-backup/custom/');
    }

     /**
     * Move the buckup of functions-custom-0.php and functions-custom-1.php from ../../../hui-backup/custom/ to ./custom/ when the plugin is activated
     * Ignore $target_file_name
     */
    public function cover_backup(){
        //Remove ./custom/
        $this -> delete_dir('./custom/');

        //Copy ../../../hui-backup/custom/ to ./custom/
        $this -> copy_dir('../../../hui-backup/custom/', 'custom/');

        //Delete ../../../hui-backup/custom/
        return $this -> remove_backup();
    }
}
?>