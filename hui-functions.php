<?php
/**
 * All functions here
 */

//Add language support
// load_plugin_textdomain('hui', false, basename(dirname( __FILE__ )).'/languages' );

function hui_copy_dir($hui_before, $hui_after){
    $src = $hui_before;
    $dst = $hui_after;

    $dir = opendir($src);
    mkdir($dst);
    while(false !== ($file = readdir($dir))){
        if(($file != '.') && ($file != '..')){
            if(is_dir($src.$file)){
                recurse_copy($src.$file, $dst.$file);
            }
            else {
                copy($src.$file, $dst.$file);
            }
        }
    }
    closedir($dir);
    return true;
}

function hui_delete_dir($hui_path){
    $dir = $hui_path;

    $handle = opendir($dir);
    while(($file = readdir($handle)) !== false){
        if($file != '.' && $file != '..'){
            $file_path = $dir.$file;
            unlink($file_path);
        }
    }
    closedir($handle);
    return rmdir($dir);
}

/**
 * Create a buckup of functions-custom-0.php and functions-custom-1.php when the plugin is deactivated
 * Create a copy in ../../../hui-backup/custom/
 * Will be deleted when the plugin is activated or in the process of uninstallation
 */
function hui_create_backup(){
    return hui_copy_dir('./custom/', '../../../hui-backup/');
}

/**
 * Remove the buckup of functions-custom-0.php and functions-custom-1.php in ../../../hui-backup/custom/ when the plugin is in the process of uninstallation
 */
function hui_remove_backup(){
    return hui_delete_dir('../../../hui-backup/');
}

 /**
 * Move the buckup of functions-custom-0.php and functions-custom-1.php from ../../../hui-backup/custom/ to ./custom/ when the plugin is activated
 */
function hui_cover_backup(){
    //Remove ./custom/
    hui_delete_dir('./custom/');

    //Copy ../../../hui-backup/custom/ to ./custom/
    hui_copy_dir('../../../hui-backup/', 'custom/');

    //Delete ../../../hui-backup/custom/
    return hui_remove_backup();
}
?>