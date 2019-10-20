<?php

/**
 * Template Name: ajax-empty-basket
 */

if(isset($_SESSION['basket'])  && isset($_GET['unset'])){
	unset($_SESSION['basket']);
	if(!isset($_SESSION['basket'])){
	}
}

if(isset($_SESSION['product_basket'])  && isset($_GET['unset'])){
	unset($_SESSION['product_basket']);
	unset($_SESSION['total_incur_other']);
	unset($_SESSION['total_incur_product']);
	
	if(!isset($_SESSION['product_basket'])){
		echo "";
	}
}



?>