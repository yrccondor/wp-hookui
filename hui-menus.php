<?php
/**
 * Add menus to the admin pannel
 */

//Add menu
function hui_admin_menu(){
    add_menu_page('WPHookUI' , 'WPHookUI', 'edit_themes', 'hui_admin','hui_display_main_menu','dashicons-admin-tools');
}
//Add sub menus
function hui_add_admin(){
    add_submenu_page('hui_admin', __('动作管理', 'hui'), __('动作管理', 'hui'), 'edit_themes', 'hui_functions', 'hui_display_sub_menu_functions');
    add_submenu_page('hui_admin', __('关于', 'hui'), __('关于', 'hui'), 'edit_themes', 'hui_about', 'hui_display_sub_menu_about');
}
function hui_display_main_menu(){
    echo '<h1>WPHookUI</h1>';
}
function hui_remove_sub_menu() {
    remove_submenu_page('hui_admin', 'hui_admin');
}
add_action('admin_menu', 'hui_admin_menu');
add_action('admin_menu', 'hui_add_admin');
add_action('admin_menu', 'hui_remove_sub_menu');

//Display sub menus
function hui_display_sub_menu_functions(){
    include('includes/submenu-functions.php');
}
function hui_display_sub_menu_about(){
    wp_register_style('hui_admin_about', plugins_url('css/admin-about.css',__FILE__));
    wp_enqueue_style('hui_admin_about');
    include('includes/submenu-about.php');
}
?>