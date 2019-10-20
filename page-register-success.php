<?php
/**
 * Template Name: registersuccess

 */

 ?>

<?php

$success = 0;
$error_msg = "";
$user_id = "";
$website = get_site_url();


// success
if(isset($_POST['submit'])){

  unset($_SESSION['agent_error_msg']);


  $first_name = '';       if(isset($_POST['first_name'])) $first_name = $_POST['first_name'];
  $last_name = '';        if(isset($_POST['last_name'])) $last_name = $_POST['last_name'];
  $phone = '';        	  if(isset($_POST['phone'])) $phone = $_POST['phone'];
  $company_name = '';     if(isset($_POST['company_name'])) $company_name = $_POST['company_name'];
  $agent_state = '';      if(isset($_POST['agent_state'])) $agent_state = $_POST['agent_state'];
  $agent_state_name = '';      if(isset($_POST['agent_state_name'])) $agent_state_name = $_POST['agent_state_name'];
  $agent_locals = '';     if(isset($_POST['agent_locals'])) $agent_locals = $_POST['agent_locals'];
  $address = '';          if(isset($_POST['address'])) $address = $_POST['address'];
  $agent_about_you = '';  if(isset($_POST['agent_about_you'])) $agent_about_you = $_POST['agent_about_you'];
  $company_color = '';     if(isset($_POST['company_color'])) $company_color = $_POST['company_color'];


  $_SESSION['agent_first_name'] = $first_name;
  $_SESSION['agent_last_name'] = $last_name;
  $_SESSION['agent_phone'] = $phone;
  $_SESSION['agent_company_name'] = $company_name;
  $_SESSION['agent_state'] = $agent_state;
  $_SESSION['agent_locals'] = $agent_locals;
  $_SESSION['agent_address'] = $address;
  $_SESSION['agent_email'] = @$_POST['email'];
  $_SESSION['agent_about_you'] = $agent_about_you;
  $_SESSION['agent_company_color'] = $company_color;


	if ( !username_exists( $_POST['email'] ) ) {
    
    if( !email_exists( $_POST['email'] ) ) {

    $website = "";
          $userdata = array(
            'user_login' =>  @$_POST['email'],
            'user_url'   =>  $website,
            'user_pass'  =>  @$_POST['password'], // When creating an user, `user_pass` is expected.
            'user_email'   =>  @$_POST['email']
          );
 
     $user_id = wp_insert_user( $userdata ) ;

     $user_ = new WP_User($user_id);
     $user_->set_role('vendors');

     $_SESSION['customer_id'] = $user_id;

     if(isset($user_id)){


       // upload file
if(isset($_FILES['upload'])){
if($_FILES['upload']['size'] > 0 && $_FILES['upload']['size'] <= 1000000){

            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }

            $photo_file_name = uniqid();

            $uploadedfile = @$_FILES['upload'];
            $upload_overrides = array(
                 'test_form' => false,
                 'unique_filename_callback' => 'my_cust_filename'
            );

            function my_cust_filename($dir, $name, $ext){
                $name = $GLOBALS['photo_file_name'] . $ext;
                return $name;
            }

             $photo_file_full = wp_handle_upload( $uploadedfile, $upload_overrides );


            if ( $photo_file_full && !isset( $photo_file_full['error'] ) ) {
              $filepath = $photo_file_full['url'];
            }

            update_user_meta( $user_id, 'field_with_custom_avatar', sanitize_text_field( $filepath ) );

} else if($_FILES['upload']['size'] > 1000000 ){

     $error_msg = "Sorry, your file is too large. Your photo should be less than 1 MB";

} else {

     $error_msg = "Error occurred, please try again.";
}

}


     		       update_user_meta( $user_id, 'first_name', sanitize_text_field( $first_name ) );
               update_user_meta( $user_id, 'last_name', sanitize_text_field( $last_name ) );
               update_user_meta( $user_id, 'phone', sanitize_text_field( $phone ) );
               update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $phone ) );
               update_user_meta( $user_id, 'company_name', sanitize_text_field( $company_name ) );

               update_user_meta( $user_id, 'billing_state', sanitize_text_field( $agent_state_name ) ); 
               update_user_meta( $user_id, 'billing_address', sanitize_text_field( $address ) );
               update_user_meta( $user_id, 'agent_locals', sanitize_text_field( $agent_locals ) );
               update_user_meta( $user_id, 'company_name', sanitize_text_field( $company_name ) );
               update_user_meta( $user_id, 'company_color', sanitize_text_field( $company_color ) );
               update_user_meta( $user_id, 'description', sanitize_text_field( $agent_about_you ) );

               

               $success = 1;
               unset_register_data();
               send_email_after_registration($user_id);

               // Automatic login //
				$username = $_POST['email'];
				$user = get_user_by('login', $username );

				// Redirect URL //
				if ( !is_wp_error( $user ) )
				{
				    wp_clear_auth_cookie();
				    wp_set_current_user ( $user->ID );
				    wp_set_auth_cookie  ( $user->ID );

				    $redirect_to = get_site_url();
				    wp_safe_redirect( $redirect_to );
				    exit();
				}

     }

 } else {
    // Username
    $error_msg = "Email already exist";

 }

} else {

	// Email
    $error_msg = "Email already exist";

}

$_SESSION['agent_error_msg'] = $error_msg;

if(isset($_SESSION['agent_error_msg'])){

	wp_safe_redirect( get_site_url() . "/register?error=1" );
	exit();
}


}

?>