<?php
/**
 * Template Name: test

 */

//get_header(); ?>


<?php

    // $order = new WC_Order( 1390 );
    // $to_email = "tosinmath007@gmail.com";
    // $headers = 'From: Drinks.ng <contact@roismedia.com>' . "\r\n";
    // wp_mail($to_email, 'subject', 'message', $headers );




// $category_list = "";
//         if(isset($_SESSION['categories'])){
//             $category_list = $_SESSION['categories'];
//         }

//         $response = get_email_proposal($category_list);
//         echo $response;


// $headers = "From: Drinks.ng <contact@roismedia.com>\r\n";
//         $headers .= "Content-Type: text/html; charset=UTF-8";

//         $to = "tosinmath007@yahoo.com";
//         $subject = 'Drinks calculations from Drinks.ng';

//         //echo $response;
        

//         if(wp_mail( $to, $subject, $response, $headers )){
//             echo "<script> alert('Mail sent to client!'); </script>";
//         }
/*
global $woocommerce;

  $address = array(
      'first_name' => '111Joe',
      'event_date'  => '20-05-2018',
      'company'    => 'Speed Society',
      'email'      => 'joe@testing.com',
      'phone'      => '760-555-1212',
      'address_1'  => '123 Main st.',
      'address_2'  => '104',
      'city'       => 'San Diego',
      'state'      => 'Ca',
      'postcode'   => '92121',
      'country'    => 'US'
  );

  // Now we create the order
  $order = wc_create_order();

  echo $order->get_id();

  // The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
  //$order->add_product( get_product('275962'), 1); // This is an existing SIMPLE product
  $order->set_address( $address, 'billing' );

  $note = "Event date: " . "20-05-2018" . "\n\r";
  $note .= "Event type: " . "Wedding" . "\n\r";
  $note .= "No of Guest: " . "20" . "\n\r";

// Add the note
  $order->add_order_note( $note );
  //
  $order->calculate_totals();
  $order->update_status("Completed", 'Imported order', TRUE);  
*/

?>

<!-- <script src="https://js.paystack.co/v1/inline.js"></script>
<div id="paystackEmbedContainer"></div>

<script>
  PaystackPop.setup({
   key: 'pk_test_e3263039023f38cce66cf41dbd9f582e39a2f52c',
   email: 'customer@email.com',
   amount: 10000,
   container: 'paystackEmbedContainer',
   callback: function(response){
        alert('successfully subscribed. transaction ref is ' + response.reference);
    },
  });
</script> -->



<?php

echo strlen("Absolut Citron – 1LTR");

/* highlight_string("<?php\n\$data =\n" . var_export($_SESSION['product_basket'], true) . ";\n?>"); */

/* highlight_string("<?php\n\$data =\n" . var_export($_SESSION['basket'], true) . ";\n?>"); */

// for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
//      echo $_SESSION['product_basket']['product'][$i]['name'];
// }

		// $categories  = array(); 
  //       for($i=0,$j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
  //       	if(!in_array($_SESSION['product_basket']['product'][$i]['category_name'], $categories)){
  //       		$categories[$j] = $_SESSION['product_basket']['product'][$i]['category_name'];
  //       		$j++;
  //       	}
  //       }
        
  /* highlight_string("<?php\n\$data =\n" . var_export($_SESSION['selected_vendor'], true) . ";\n?>");  */


// global $wpdb;
// 	$query = "
//      SHOW COLUMNS FROM wp_location_of_event
//    ";
//    $result = $wpdb->get_results($query);
//    $data="";

//    foreach($result as $res){
//    		echo $res->Field;
//    }


?>

