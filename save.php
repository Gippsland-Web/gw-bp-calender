<?php
/*
* Title                   : Ajax Booking Calendar Pro
* Version                 : 1.1
* File                    : load.php
* File Version            : 1.0
* Created / Last Modified : 24 May 2011
* Author                  : Marius-Cristian Donea
* Copyright               : © 2011 Marius-Cristian Donea
* Website                 : http://www.mariuscristiandonea.com
* Description             : Booking Calendar save data script file.
*/
session_start();
global $wpdb, $table_prefix;
if(!isset($wpdb))
{
	require_once('../../../wp-config.php');
	require_once('../../../wp-includes/wp-db.php');
}

if ( isset($_SESSION['cal_member_id']) && isset($_SESSION['cal_id'])) {
    if (isset($_POST['dop_booking_calendar'])){

        //only save the data if the logged in user is editing their calender.
        if($_SESSION['cal_member_id'] == $_SESSION['cal_id'])  
        {
            if($wpdb->get_row($wpdb->prepare("SELECT (id) FROM {$wpdb->prefix}gwcalendar WHERE id=%d",$_SESSION['cal_member_id'])) != null) {
            $result = $wpdb->update("wp_gwcalendar",
                array('cal_data' => $_POST['dop_booking_calendar']),
                array('id' => $_SESSION['cal_member_id']),
                array('%s'),array('%d')
                );
            }
            else {
                $result = $wpdb->insert("wp_gwcalendar",
                    array('id'=> $_SESSION['cal_member_id'], 'cal_data' => $_POST['dop_booking_calendar']),
                    array('%d' ,'%s')
                    );
            }
        }
    }
}
?>