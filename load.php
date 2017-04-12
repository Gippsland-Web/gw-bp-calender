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
* Description             : Booking Calendar load data script file.
*/
error_reporting(0);
session_start();
global $wpdb, $table_prefix;
if(!isset($wpdb))
{
    require_once('../../../wp-config.php');
    require_once('../../../wp-includes/wp-db.php');
}
 
//var_dump($_SESSION);
 
 
if(isset($_SESSION['cal_id']))
{
    $result = $wpdb->get_row(
        $wpdb->prepare("SELECT cal_data FROM {$wpdb->prefix}gwcalendar WHERE id=%d",$_SESSION['cal_id'])
    );
 
    if(!isset($result)) {
        return;
    }
    else {
        echo($result->cal_data);
    }
}
else {
            trigger_error('Trying to save Calendar data when not logged in.', E_USER_ERROR);
}
 
   
?>