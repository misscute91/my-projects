<?php

/**
 * Template Name: ajax-location-event
 */




if(isset($_GET['local_id'])){

    $column = "";
    $column = str_replace("-"," ", $_GET['local_id']);
    $column = strtolower(str_replace(" ","_", $column));

    $column_exist = false;
	global $wpdb;
    $query1 = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'eventscalculatordb' AND TABLE_NAME = 'wp_location_of_event' AND COLUMN_NAME = '" . $column . "' ";
    $result1 = $wpdb->get_results($query1);
    if(sizeOf($result1) > 0 ){
        $column_exist = true;
    }


	$str = "";

    if($column_exist == true){
    	$query = "SELECT " . $column . " FROM wp_location_of_event WHERE " . $column . " != '' ";
        $result = $wpdb->get_results($query);
        $i = 0;
        foreach($result as $res){
        	if($i == 0) $str .=  $res->$column;
        	if($i > 0) $str .=  "," . $res->$column;
        	$i++;
        }
    }

 	echo $str;
}


?>

