<?php
/*
 Plugin Name: GW Calendar
 Plugin URI: 
 Description: Adds an availability Calendar to BP
 Author: GippslandWeb
 Version: 1.3.1
 Author URI: https://wordpress.org/
 GitHub Plugin URI: Gippsland-Web/gw-bp-calender
 */


/*
* Init function
*/

 // function to create the DB / Options / Defaults
 function gw_plugin_options_install() {
    global $wpdb;
    $gw_cal_db_name = $wpdb->prefix . 'gwcalendar';

    // create the ECPT metabox database table
    if($wpdb->get_var("show tables like '$gw_cal_db_name'") != $gw_cal_db_name) 
    {
        $sql = "CREATE TABLE " . $gw_cal_db_name . " (
            `id` mediumint(9) NOT NULL,
            `cal_data` mediumtext NOT NULL,
            `cal_enabled` tinyint NOT NULL,
            UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);                     
    }          
 }
 // run the install scripts upon plugin activation
 register_activation_hook(__FILE__,'gw_plugin_options_install');

//Add the menu item
 function profile_new_nav_item() {
    global $bp;
    bp_core_new_nav_item(
    array(
        'name'                => 'Availability',
        'slug'                => 'calendar',
        'screen_function'     => 'view_manage_tab_cal',
        'parent_url'      => bp_displayed_user_domain()  . '/calendar/',
        'parent_slug'     => $bp->profile->slug,
        'default_subnav_slug' => 'calendar'
    )
    );
}
add_action( 'bp_setup_nav', 'profile_new_nav_item', 10 );


function view_manage_tab_cal() {
    add_action( 'bp_template_title', 'gw_main_cal_title' );
    add_action( 'bp_template_content', 'gw_main_cal_content' );
    bp_core_load_template( 'members/single/plugins' );
}
function gw_main_cal_title() {
    echo 'Availability';
}

//Add ability to show from a short code
add_shortcode("gw-calendar","gw_main_cal_get_content");

function gw_main_cal_content() {
	echo gw_main_cal_get_content();
}

function gw_main_cal_get_content() {
	    global $bp;
    if ( ! is_user_logged_in() ) {
        return "";
		//wp_login_form( array( 'echo' => true ) );
    }
    else {
       $_SESSION['cal_id'] = bp_displayed_user_id();
       $_SESSION['cal_member_id'] = get_current_user_id();

        $data = "<script src='/wp-content/plugins/gw-bp-calender/dist/jquery.dop.BookingCalendar.min.js'></script> <script type='text/javascript'>
            jQuery.noConflict() (function($) {
            $(document).ready(function() {
            $('#backend').DOPBookingCalendar({
            'Type':'BackEnd',
            'DataURL':'/wp-content/plugins/gw-bp-calender/load.php',";
        if(bp_displayed_user_id() == get_current_user_id()) {
            $data = $data."'SaveURL':'/wp-content/plugins/gw-bp-calender/save.php'";
        }
        $data = $data."});     });       });
            </script>
            <div id='calContainer'><div id='backend-container'><div id='backend'>
            </div></div></div>";        
	return $data;
	}
}


function register_calendar_style() {
      //if ( is_page( 'calendar' )  || is_page( 'Availability' )  ) {
        wp_enqueue_style( 'calendar', plugins_url('/gw-bp-calender/dist/jquery.dop.BookingCalendar.css', dirname(__FILE__)) );
        wp_enqueue_script( 'calendar', plugins_url('/gw-bp-calender/dist/jquery.dop.BookingCalendar.min.js', dirname(__FILE__)), array(), '1.0.0', true );
     // }

}
add_action( 'wp_enqueue_scripts', 'register_calendar_style' );





add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
        if(!session_id()) {
                    session_start(); 
        }
}


function myEndSession() {
        session_destroy ();
}