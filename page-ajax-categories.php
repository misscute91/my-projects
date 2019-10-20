<?php

/**
 * Template Name: ajax-categories
 */

function totalincur(){
	$sum = 0;
	if(isset($_SESSION['basket'])){
		for($i=0; $i<sizeof($_SESSION['basket']['category']); $i++){
			$bottle = (int)$_SESSION['basket']['category'][$i]['bottle'];
			$minprice = (int)$_SESSION['basket']['category'][$i]['minprice'];
			$sum += $minprice * $bottle;
		}
	}
	return $sum;
}


if(isset($_GET['action']) && isset($_GET['minprice']) && isset($_GET['category_name']) && isset($_GET['budget'])){

		$action = $_GET['action'];
		$bottle = 0; if(isset($_GET['qty'])) $bottle = (int)$_GET['qty'];

		if(isset($_SESSION['basket'])){

			$category_info = array(
				"name" => $_GET['category_name'],
				"minprice" => $_GET['minprice'],
				"bottle" => $bottle
			);

			$categories = array();

			$found = false;
			$i = 0;
			if($action == "add"){
				for($i, $j=0; $i<sizeof($_SESSION['basket']['category']); $i++){
					$categories[$j] = @$_SESSION['basket']['category'][$i];
					$j++;
				}
				$categories[$i++] = $category_info;
				$found = true;

			} else if($action == "remove"){
				for($i, $j=0; $i<sizeof($_SESSION['basket']['category']); $i++){
					if($_GET['category_name'] != @$_SESSION['basket']['category'][$i]['name']){
						$categories[$j] = @$_SESSION['basket']['category'][$i];
						$j++;
					}
				}
				$found = true;
				remove_items_from_product($_GET['category_name'], $_GET['budget']);
			}


			if($found == false){

				if($action == "addplus" || $action == "substract" || $action == "add_subtract"){

					for($i, $j=0; $i<sizeof($_SESSION['basket']['category']); $i++){
						if(strtolower($_GET['category_name']) == strtolower(@$_SESSION['basket']['category'][$i]['name'])){
							$_SESSION['basket']['category'][$i]['bottle'] = $bottle;
						}
					}
					$_SESSION['basket']['totalincur'] = totalincur();
				}

			} else {

				$basket = array(
					"budget" => $_GET['budget'],
					"balance" => 0,
					"totalincur" => 0,
					"category" => $categories
				);
				$_SESSION['basket'] = $basket;
				$_SESSION['basket']["totalincur"] = totalincur();

			}
			

		} else {
 
			$category_info = array(
				"name" => $_GET['category_name'],
				"minprice" => $_GET['minprice'],
				"bottle" => $bottle
			);

			$categories = array();
			$categories[0] = $category_info;
			$basket = array(
				"budget" => $_GET['budget'],
				"balance" => 0,
				"totalincur" => 0,
				"category" => $categories
			);


			$_SESSION['basket'] = $basket;
			$_SESSION['basket']["totalincur"] = totalincur();
		}


	header('Content-Type: application/json');
	echo json_encode($_SESSION['basket']);
 	//var_dump( $_SESSION['basket'] );
 	/*highlight_string("<?php\n\$data =\n" . var_export($_SESSION['basket'], true) . ";\n?>");*/

}



?>

