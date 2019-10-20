<?php

/**
 * Template Name: ajax-pay-order
 */


function get_page_by_slug($page_slug, $post_type = 'product' ) { 
  global $wpdb; 
   $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) ); 
   
   return $page;
}



if(isset($_GET['pay'])){


//if(isset($_SESSION['product_basket'])){


global $woocommerce;

  $address = array(
      'first_name' => @$_GET['client_name'],
      'email'      => @$_SESSION['email'],
      'phone'      => @$_GET['client_phone'],
      'address_1'  => @$_GET['delivery_address'],
      'city'       => @$_SESSION['locals'],
      'state'      => @$_SESSION['state'],
      'country'    => 'NG'
  );



$order = "";

if($_GET['pay'] == "2"){
    $order_id = $_SESSION['custom_order_id'];
    $order = wc_update_order( array ( 'order_id' => $order_id ) );

} else if($_GET['pay'] == "3"){
    $order_id = $_SESSION['custom_order_id'];
    $order = wc_update_order( array ( 'order_id' => $order_id ) );
    $order->update_status("completed", 'Imported order', TRUE); 
    exit();

} else {

    $order = wc_create_order();
}

if (is_wp_error( $order )){
  $order = wc_create_order();
}


if(isset($_SESSION['product_basket'])){
    for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
        $name = $_SESSION['product_basket']['product'][$i]['name'];
        $name = str_replace(" ", "-", $name);
        $name = strtolower($name);

        $qty = $_SESSION['product_basket']['product'][$i]['bottle'];
        if($name != "" && $qty != 0){
  	         $product_id = get_page_by_slug($name);
  	         $order->add_product( get_product($product_id), $qty);
    	  }
    }
}


$order->set_address( $address, 'billing' );
if($_GET['pay'] == "1"){
  $note = "State: " . stripslashes(@$_SESSION['state_name']) . "\n\r";
  $note .= "Local Govt: " . stripslashes(@$_SESSION['locals']) . "\n\r";
  $note .= "Location of Event: " . stripslashes(@$_SESSION['location_of_event']) . "\n\r";
  $note .= "Event date: " . @$_SESSION['event_date'] . "\n\r";
  $note .= "Event type: " . @$_SESSION['event_type'] . "\n\r";
  $note .= "No of Guest: " . @$_SESSION['no_of_guest'] . "\n\r";
  $note .= "Your Budget: " . @$_SESSION['budget'] . "\n\r";
  $note .= "Email Address: " . @$_SESSION['email'] . "\n\r";

  if(isset($_SESSION['selected_vendor'])){
      $note .= "Vendor Name: " . @$_SESSION['selected_vendor'] . "\n\r";
  }

  $order->add_order_note( $note );
}

  
  $order->calculate_totals();


  if($_GET['pay'] == "2"){
    $order->update_status("pending", 'Imported order', TRUE); 
  } 

	$_SESSION['custom_order_id'] = $order->get_id();

//}

}

?>

