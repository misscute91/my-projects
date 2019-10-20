<?php

if(isset($_GET['action']) && isset($_GET['minprice']) && isset($_GET['category_name']) && isset($_GET['budget'])){

		$action = $_GET['action'];

		if(isset($_SESSION['basket'])){

			$category_info = array(
				"name" => $_GET['category_name'],
				"minprice" => $_GET['minprice'],
				"bottle" => 0
			);

			$category = array();
			$categories = array();

			$i = 0;
			if($action == "add"){
				for($i, $j=0; $i<sizeof($_SESSION['basket']['category']); $i++){
					$categories[$j] = @$_SESSION['basket']['category'][$i];
					$j++;
				}
				$categories[$i++] = $category_info;

			} else {
				for($i, $j=0; $i<sizeof($_SESSION['basket']['category']); $i++){
					if($_GET['category_name'] != @$_SESSION['basket']['category'][$i]['name']){
						$categories[$j] = @$_SESSION['basket']['category'][$i];
						$j++;
					}
				}
			}

			
			$basket = array(
				"budget" => $_GET['budget'],
				"balance" => 0,
				"category" => $categories
			);
			$_SESSION['basket'] = $basket;

		} else {
 
			$category_info = array(
				"name" => $_GET['category_name'],
				"minprice" => $_GET['minprice'],
				"bottle" => 0
			);

			$categories = array();
			$categories[0] = $category_info;
			$basket = array(
				"budget" => $_GET['budget'],
				"balance" => 0,
				"category" => $categories
			);
			$_SESSION['basket'] = $basket;
		}


	header('Content-Type: application/json');
	echo json_encode($_SESSION['basket']);
 	//var_dump( $_SESSION['basket'] );
 	/*highlight_string("<?php\n\$data =\n" . var_export($_SESSION['basket'], true) . ";\n?>");*/

}



?>

