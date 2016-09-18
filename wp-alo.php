<?php
/*
 * Plugin Name: Alo - Server Probe
 * Plugin URI: https://asif.im/alo
 * Description: Alo Server Probe for WP
 * Version: 0.0.1
 * Author: M Asif Rahman
 * Author URI: https://asif.im/
 * License: GPLv2+
 * Text Domain: wp-alo
 * Min WP Version: 2.5.0
 * Max WP Version: 4.6.1
 */


define("WPALO_PLUGIN_SLUG",'wp-alo');
define("WPALO_PLUGIN_URL",plugins_url("",__FILE__ ));#without trailing slash (/)
define("WPALO_PLUGIN_PATH",plugin_dir_path(__FILE__)); #with trailing slash (/)

include_once(WPALO_PLUGIN_PATH.'alo-server-probe.php');

function add_wpalo_menu_pages()

{
add_options_page( "Alo Server Probe", "Alo Server Probe" ,'manage_options', WPALO_PLUGIN_SLUG, 'alo_server_probe');
}

add_action('admin_menu', 'add_wpalo_menu_pages'); 



function wpalo_setting_links($links, $file) {
    static $wpalo_setting;
    if (!$wpalo_setting) {
        $wpalo_setting = plugin_basename(__FILE__);
    }
    if ($file == $wpalo_setting) {
        $wpalo_settings_link = '<a href="options-general.php?page='.WPALO_PLUGIN_SLUG.'">Server Probe</a>';
        array_unshift($links, $wpalo_settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'wpalo_setting_links', 10, 2);

/* Display a notice that can be dismissed */

add_action('admin_notices', 'wpalo_admin_notice');

function wpalo_admin_notice() {
if ( current_user_can( 'install_plugins' ) )
   {
     global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
     if ( ! get_user_meta($user_id, 'wpalo_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('See the Alo Server Probe report <a href="options-general.php?page='.WPALO_PLUGIN_SLUG.'">here</a>. <a href="%1$s">[Hide]</a>'), admin_url( 'admin.php?page=wp-alo&wpalo_nag_ignore=0'));
        echo "</p></div>";
     }
    }
}


add_action('admin_init', 'wpalo_nag_ignore');

function wpalo_nag_ignore() {
     global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['wpalo_nag_ignore']) && '0' == $_GET['wpalo_nag_ignore'] ) {
             add_user_meta($user_id, 'wpalo_ignore_notice', 'true', true);
     }
}
?>