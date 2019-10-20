<?php

/**
 * Template Name: ajax-products
 */

// unset($_SESSION['product_basket']);
// unset($_SESSION['basket']);
// exit;


if(isset($_GET['action']) && isset($_GET['price']) && isset($_GET['category_name']) 
	&& isset($_GET['budget']) && isset($_GET['product_name']) && isset($_GET['qty']) ){  

		$action = $_GET['action'];

		if(isset($_SESSION['product_basket'])){

			$products = array();
			$found = false;

			$i = 0;
			if($action == "add"){
				for($i, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
					if(@$_SESSION['product_basket']['product'][$i]['name'] == $_GET['product_name']){
						$total = (int)$_GET['qty'] * (int)$_GET['price'];
						@$_SESSION['product_basket']['product'][$i]['bottle'] = $_GET['qty'];
						@$_SESSION['product_basket']['product'][$i]['total'] = $total;
						$found = true;
					}
				}

			} 
			else if($action == "substract"){
				for($i, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
					if(@$_SESSION['product_basket']['product'][$i]['name'] == $_GET['product_name']){
						$quantity = (int)$_GET['qty'];
						$quantity--;
						$total = $quantity * (int)$_GET['price'];
						@$_SESSION['product_basket']['product'][$i]['bottle'] = $quantity;
						@$_SESSION['product_basket']['product'][$i]['total'] = $total;
						$found = true;
					}
				}

			} else if($action == "remove"){
				for($i, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
					if($_GET['product_name'] != @$_SESSION['product_basket']['product'][$i]['name']){
						$products[$j] = @$_SESSION['product_basket']['product'][$i];
						$j++;
					}
				}
				$basket = array(
					"budget" => $_GET['budget'],
					"balance" => 0,
					"product" => $products
				);
				$_SESSION['product_basket'] = $basket;
				$found = true;
			}


			if($found == false){

				$total = (int)$_GET['qty'] * (int)$_GET['price'];
				$product_info = array(
					"name" => $_GET['product_name'],
					"price" => $_GET['price'],
					"bottle" => $_GET['qty'],
					"category_name" => $_GET['category_name'],
					"total" => $total,
					"carton" => @$_GET['carton']
				);

				$products = array();
				$products[0] = $product_info;

				$i = 0;
				if($action == "add" ){
					for($i, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
						$products[$j] = @$_SESSION['product_basket']['product'][$i];
						$j++;
					}
					$products[$i++] = $product_info;

				} else if($action == "substract"){
					for($i, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
						if($_GET['product_name'] != @$_SESSION['product_basket']['product'][$i]['name']){
							$categories[$j] = @$_SESSION['product_basket']['product'][$i];
							$j++;
						}
					}
				}

				$basket = array(
					"budget" => $_GET['budget'],
					"balance" => 0,
					"product" => $products
				);
				$_SESSION['product_basket'] = $basket;

			}


		} else {
 
			$product_info = array(
				"name" => $_GET['product_name'],
				"price" => $_GET['price'],
				"bottle" => 1,
				"category_name" => $_GET['category_name'],
				"total" => $_GET['price'],
				"carton" => @$_GET['carton']
			);

			$products = array();
			$products[0] = $product_info;
			$basket = array(
				"budget" => $_GET['budget'],
				"balance" => 0,
				"product" => $products
			);
			$_SESSION['product_basket'] = $basket;
		}


	header('Content-Type: application/json');
	echo json_encode($_SESSION['product_basket']);
 	//var_dump( $_SESSION['product_basket'] );
 	/*highlight_string("<?php\n\$data =\n" . var_export($_SESSION['product_basket'], true) . ";\n?>");*/

}



?>

