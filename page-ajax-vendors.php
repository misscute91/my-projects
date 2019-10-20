<?php

/**
 * Template Name: ajax-vendors
 */


if(isset($_GET['action']) && isset($_GET['selected_vendor']) && isset($_GET['category_name']) ){  


		$selected_vendor = array();
		$action = $_GET['action'];
		if($action == "add" ){
			$_SESSION['selected_vendor'] = $_GET['selected_vendor'];
			$selected_vendor[0] = "OK";
		}
		if($action == "remove" ){
			unset($_SESSION['selected_vendor']);
			$selected_vendor[0] = "DOES_NOT_EXIST";
		}
		if($action == "check" ){
			$selected_vendor[0] = "OK";
			if(!isset($_SESSION['selected_vendor'])){
				$selected_vendor[0] = "DOES_NOT_EXIST";
			} 
		}

	header('Content-Type: application/json');
	echo json_encode($selected_vendor);
	
}


	





?>

