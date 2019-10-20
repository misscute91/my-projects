<?php

/**
 * Template Name: ajax-locals
 */

$json = file_get_contents('states.json', true);
$states_array = json_decode($json, TRUE);


if(isset($_GET['state_id'])){
	$locals_arr = $states_array[$_GET['state_id'] - 1]['state']['locals'];
	$list_of_locals = "";
	$len = count($locals_arr) - 1;
	for($i=0; $i<=$len; $i++){
        $list_of_locals .=  $locals_arr[$i]['name'];
        if($i != $len){
        	$list_of_locals .=  ",";
        }
    } 

 	echo $list_of_locals;
}


?>

