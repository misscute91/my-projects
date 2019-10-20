<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>

<![endif]-->

<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); ?>>

<![endif]-->

<!--[if !(IE 7) & !(IE 8)]><!-->

<html <?php language_attributes(); ?> >
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <meta name="author" content="" />
  <meta name="description" content="" />
  
  <title><?php echo get_option('blogname'); ?> - <?php echo ucfirst(get_the_title()); ?></title>

  <script>document.documentElement.className = 'js';</script>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="apple-touch-icon" type="image/png" href="images/apple-touch-icon.png" />
    
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-grid.min.css" />

  <?php if($pagename == "step-three"){ ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/component.css" />
  <?php } ?>

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/layout.css" />
  
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/application.css" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-datepicker3.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,800,900" rel="stylesheet">


  <?php
  // css styles needed in only some pages
  if($pagename == ""){
    echo "<link rel='stylesheet' href='" . get_template_directory_uri(). "/css/jquery-ui.css'>";
  }
  if($pagename == "register"){
    echo "<link rel='stylesheet' type='text/css' href='" . get_template_directory_uri(). "/css/spectrum.min.css'>";
  }

  ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom.css" />


<?php //wp_head(); ?>

<?php
global $post;

//wp_head();

if ( is_page()  ) {
remove_filter( 'the_content', 'wpautop' ); 
remove_filter( 'the_excerpt', 'wpautop' );  
}
/** Add attributes for Span element because of FrontEnd Editor **/

?>

<?php

if(isset($_POST['change_budget'])){
        $_SESSION['budget'] = str_replace(",", "", $_POST['change_budget']);
}

?>

</head>
<body <?php if($pagename == "step-three"){ echo "class='cbp-spmenu-push' "; } ?> > 



<?php if($pagename == "step-three"){ ?>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left main-pro-container" id="cbp-spmenu-s2" >
      <div class="side-bar-main-container">
                  <div class="link-cont">
                <div class="link">
                    <a class="back-btn showRightPush">Close Category</a>
                    <h4 class="title">Drinks Category</h4>
                    <ul>
<?php
$args = array(
    'number'     => @$number,
    'orderby'    => @$orderby,
    'order'      => @$order,
    'hide_empty' => @$hide_empty,
    'include'    => @$ids
);

$product_categories = get_terms( 'product_cat', $args);
$i = 0;
foreach( $product_categories as $cat ) { 
  if($cat->name != "other services"){
        $active = "";
        if(isset($_GET['product_cat']) && $_GET['product_cat'] != ""){
          if($_GET['product_cat'] == $cat->slug){
            $active = "active";
          }
        }

        $bottles = 0;
        if(isset($_SESSION['product_basket'])){
            for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
                $catname = str_replace(" ", "-", $cat->name);
                if($_SESSION['product_basket']['product'][$i]['category_name'] == $catname ){ 
                    $bottles += (int) $_SESSION['product_basket']['product'][$i]['bottle'];
                }
            }
        }

        if(!isset($_GET['product_cat'])){
            if($ind == 0){
                $active = "active"; 
                $ind++;
            }
        }

?>

                        <li class="<?php echo $active; ?> <?php echo $cat->slug; ?>-li">
                        <a href="<?php echo get_site_url(); ?>/step-three?product_cat=<?php echo $cat->slug; ?>"><i></i><?php echo ucwords($cat->name); ?>
                        <span class="count-down <?php if($bottles > 0){ echo "show-element"; } else { echo "hide-element"; } ?>"><?php echo $bottles; ?> BTL</span></a>
                        <input type="hidden" id="<?php echo $cat->slug; ?>-bottles" value="<?php echo $bottles; ?>" >
                        </li>
<?php } } ?>
                    </ul> 
                </div>
                </div>  
      </div>
</nav>

<?php } ?>



<?php  if($pagename != ""){  ?>

      <header class="primary static">
        
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
  <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-2.png" alt="logo" />  
</a>
        
    <a class="nav-link mobile_app outer-mobile-app" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/mobile-app.svg" alt="" /></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="<?php echo get_site_url(); ?>">Home</a></li>
      <li class="nav-item "><a class="nav-link" href="<?php echo get_site_url(); ?>/how-it-works">How it works</a></li>
      <li class="nav-item"><a class="nav-link" href="<?php echo get_site_url(); ?>/about">About</a></li>
      <li class="nav-item"><a class="nav-link" href="<?php echo get_site_url(); ?>/contact">Contact</a></li>
      <li class="nav-item"><a class="nav-link" href="<?php echo get_site_url(); ?>/register">Register</a></li>

      <?php

      if(is_user_logged_in()){ 

        $first_name = get_user_meta(get_current_user_id(), "first_name", true);
        ?>
        <li class="nav-item"><a href="<?php echo get_site_url(); ?>/login" class="btn secondry"><?php echo ucfirst($first_name); ?></a></li>
        <li class="nav-item"><a href="<?php echo wp_logout_url(  get_site_url() ); ?>" style="color:#000" class="btn">Log Out</a></li>
      <?php } else { ?>
        <li class="nav-item"><a href="<?php echo get_site_url(); ?>/login" class="btn secondry">Login</a></li>
      <?php } ?>

    </ul>
      
  </div>
  </div>
</nav>
    </header>


<?php } ?>








