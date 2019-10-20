<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/logo-footer.png" alt="" class="" /></a>
                    <p>Call Us +234 813 984 0160</p>
                    <p>Mon-Fri: 8am-5pm</p>
                    <p>Sat: 10am-5pm</p>
                </div>
                <div class="col-lg-2 col-md-12 offset-md-0 col-sm-12 text-right footer-logo">
                    
                    <ul class="lnks text-lg-left text-md-center text-sm-center">
                        <li><a href="<?php echo get_site_url(); ?>/contact">Contact Us</a></li>
                        <li><a href="">Terms and conditions</a></li>
                        <li><a href="">Privacy Policy</a></li>
                        <li><a target="_blank" href="https://www.drinks.ng/blog/">Our Blog</a></li>
                        <li><a target="_blank" href="https://www.drinks.ng">Drinks.ng</a></li>
                        <li><a target="_blank" href="https://www.spiritmagazine.drinks.ng/">Spirit Magazine</a></li>
                    </ul>
                    
                </div>
                
                <div class="col-lg-2 col-md-12 offset-md-0 col-sm-12 text-right footer-logo">
                    
                    <ul class="lnks text-lg-left text-md-center text-sm-center">
                        <li><a target="_blank" href="https://twitter.com/drinksng">Twitter</a></li>
                        <li><a target="_blank" href="https://www.instagram.com/drinks.ng/">Instagram</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/drinks.ng/">Facebook</a></li>
                    </ul>
                    
                </div>
                
                <div class="col-lg-12 col-md-12 col-sm-12 main">
                    <span class="copy">© copyright 2018 Drinks.ng all rights reserved</span>
                </div>
            </div>
        </div>
    </footer>




<div class="modal main-pro-container" tabindex="-1" role="dialog" id="view-basket">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <!-- content start -->
          
                <div class="col-12 basket-cont">
                <div class="basket">
                
                    <div class="top-sec text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                    
                        <p class="budget-label">Budget</p>
                        <?php 
                        $budjet = 0;
                        $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
                        ?>
                        <h3 class="title budget">₦<?php echo str_replace(".00", "", number_format($budjet,2,".",",")); ?></h3>
                        <a href="<?php echo get_site_url(); ?>">Change Budget</a>
                        <h3 class="title guest"><?php if(!isset($_SESSION['no_of_guest'])) { echo "0"; } else { echo @$_SESSION['no_of_guest']; } ?></h3>
                        <p><small>Number of guests</small></p>
                    </div>
                    
                    <div class="whole-cont">
                     <h4 class="basket-label"><i></i>Basket <a href="" id="empty_basket" class="pull-right"><small>Empty Basket</small></a></h4>
                    <div class="main-content">


                    <?php 

                    $total = 0;
                    if($pagename == "step-two"){

                        if(isset($_SESSION['product_basket'])){
                            for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                                    $total += (int) $_SESSION['product_basket']['product'][$j]['total'];
                            }
                        }

                        if(isset($_SESSION['basket'])){
                            $basket_list = "";
                            for($i=0; $i<sizeof($_SESSION['basket']['category']); $i++){
                                $basket_list .= "<div id='cat-id' class='pro-cat'><h4 class='basket_categories title sup-title'>
                                    <span>". $_SESSION['basket']['category'][$i]['name'] ."</span><span class='pull-right'>0 CTN</span></h4></div>";
                                
                            }
                            echo $basket_list;
                        } 


                    }

                    ?>

                    <?php if($pagename == "step-three" || $pagename == "step-four"){ ?>

                    <?php
        $product_total = 0;
        if(isset($_SESSION['product_basket'])){

        $categories  = array(); 
        for($i=0,$j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
            if(!in_array($_SESSION['product_basket']['product'][$i]['category_name'], $categories)){
                $categories[$j] = $_SESSION['product_basket']['product'][$i]['category_name'];
                $j++;
            }
        }

        $basket = "";
        
        for($i=0; $i<sizeof($categories); $i++){
            $basket .= "<div id='cat-id' class='pro-cat'>";

            $sub_total = 0;
            $carton_total = 0;
            $match = false;
            $inner_basket = "";

            for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                if($categories[$i] == $_SESSION['product_basket']['product'][$j]['category_name'] && $_SESSION['product_basket']['product'][$j]['name'] != ""){

                    $match = true;
                    $btl = $_SESSION['product_basket']['product'][$j]['bottle']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['bottle']) == true){ $btl = 0; }
                    $carton = $_SESSION['product_basket']['product'][$j]['carton']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['carton']) == true){ $carton = 0; }

                    $carton = @intval($btl / $carton);
                    $carton_total += $carton;

                    $inner_basket .= "<div class='pro-list'>";
                    $inner_basket .= "<p class='name'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                    $inner_basket .= "<p class='carton'>". $carton ."<small>cartons</small></p>";
                    $inner_basket .= "<p class='unit'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."<small>units</small></p>";
                    $inner_basket .= "<p class='total'>". $_SESSION['product_basket']['product'][$j]['total'] ."<small>Total</small></p>";
                    $inner_basket .= "</div>";
                    $sub_total += (int) $_SESSION['product_basket']['product'][$j]['total'];
                    }
            }

            $basket .= "<h4 class='title sup-title'><span>". str_replace("-", " ", $categories[$i]) ."</span><span class='pull-right'>" . $carton_total . " CTN</span></h4>";
            if($match == true) $basket .= $inner_basket;

            $basket .= "<div class='sub-total'><h4 class='title text-right'>₦ ". $sub_total ."</h4></div></div>";
            $product_total += $sub_total;
        }
        $total = $product_total;

        echo $basket;

        }

        ?>

                    <?php } ?>
                    
                        
                    </div>
                    </div>
                    
                    <div class="footer text-right">
                    <h3 class="title">₦<?php echo $total; ?></h3>
                        <h4>Total Spent</h4>
                    </div>
                    
                    
                </div>
                    
                    <!--div class="notice">1% will be charged by drink.ng for every trasaction that takes place on the site</div-->
                    <!--a href="steps-3.html" class="btn btn-next btn-block">Next</a-->
            </div>
          

          <!-- content end -->
      </div>
    </div>
  </div>
</div>



<div class="modal" role="dialog" id="budget-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          Budget Request
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
         
                    <form action="" method="post">
                    <h4 class="title">You have exceeded your budget</b></h4>
                    <p>Increase your budget</p><input type="text" id="change_budget" name="change_budget" placeholder="enter amount" required class="form-control allow_numbers_only" />
                    <button type="submit" href="" id="apply_budget" class="btn primary btn-block">Apply to budget</button>
                    </form>
 
          
      </div>
    </div>
  </div>
</div>

<div id="snackbar" ><img width="17" src="<?php echo get_template_directory_uri(); ?>/images/tick-inside-circle.png" alt="" /></div>



    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-migrate.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script> 
    <!--<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.min.js"></script> -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script> 
    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script> 
    <!--<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datepicker.min.js"></script>-->
  
  <?php
  // JS needed in only some pages
  if($pagename == ""){
    echo "<script src='" . get_template_directory_uri() . "/js/bootstrap-datepicker.min.js'></script>";
    echo "<script src='" . get_template_directory_uri() . "/js/step-1_2.js'></script>";
    echo "<script src='" . get_template_directory_uri() . "/js/jquery-ui.min.js'></script>";
  }

  if($pagename == "step-two"){
    echo "<script src='" . get_template_directory_uri() . "/js/step-2_2.js'></script>";

    if(isset($GLOBALS['total_amount_incured']) && isset($_SESSION['budget'])){
        $budget = (int) str_replace(",", "", $_SESSION['budget']);
        // if($GLOBALS['total_amount_incured'] > $budget){
        //     echo "<script> $( document ).ready(function() { $('#budget-modal').modal('show'); }); </script>";
        // }
    }
  }

  if($pagename == "step-three"){
    echo "<script src='" . get_template_directory_uri() . "/js/step-3_2.js'></script>";

    if(isset($_SESSION['total_incur_product']) && isset($_SESSION['budget'])){ 
        $budget = (int) str_replace(",", "", $_SESSION['budget']);
        if( $_SESSION['total_incur_product'] > $budget){
            echo "<script> $( document ).ready(function() { $('#budget-modal').modal('show'); }); </script>";
        }
    }
  }

  if($pagename == "step-four"){
    echo "<script src='" . get_template_directory_uri() . "/js/step-4_2.js'></script>";

    if(isset($_SESSION['total_incur_product']) && isset($_SESSION['budget'])){
        $budget = (int) str_replace(",", "", $_SESSION['budget']);
        if( $_SESSION['total_incur_product'] > $budget){
            echo "<script> $( document ).ready(function() { $('#budget-modal').modal('show'); }); </script>";
        }
    }
  }

  if($pagename == "step-five" || $pagename == "step-five-agent"){
    echo "<script src='" . get_template_directory_uri() . "/js/jquery.validate.min.js'></script>";
    echo "<script src='" . get_template_directory_uri() . "/js/step-5_2.js'></script>";
  }

  if($pagename == "register"){
    echo "<script src='" . get_template_directory_uri() . "/js/jquery.validate.min.js'></script>";
    echo "<script src='" . get_template_directory_uri() . "/js/spectrum.min.js'></script>";
    echo "<script src='" . get_template_directory_uri() . "/js/register.js'></script>";
  }

  ?>

  <?php if($pagename == "step-three"){ ?>

  <script src="<?php echo get_template_directory_uri(); ?>/js/classie.js"></script>
  <script>
    
        jQuery('document').ready(function(){
            var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
                menuRight = document.getElementById( 'cbp-spmenu-s2' ),
                menuTop = document.getElementById( 'cbp-spmenu-s3' ),
                menuBottom = document.getElementById( 'cbp-spmenu-s4' ),
                showLeft = document.getElementById( 'showLeft' ),
                showRight = document.getElementById( 'showRight' ),
                showTop = document.getElementById( 'showTop' ),
                showBottom = document.getElementById( 'showBottom' ),
                showLeftPush = document.getElementById( 'showLeftPush' ),
                showRightPush = $( '.showRightPush' ),
                body = document.body;

            showRightPush.click(function(e) {
                e.preventDefault();
                classie.toggle( this, 'active' );
                classie.toggle( body, 'cbp-spmenu-push-toright' );
                classie.toggle( menuRight, 'cbp-spmenu-open' );
                disableOther( 'showRightPush' );
            });

            function disableOther( button ) {
                if( button !== 'showLeft' ) {
                    classie.toggle( showLeft, 'disabled' );
                }
                if( button !== 'showRight' ) {
                    classie.toggle( showRight, 'disabled' );
                }
                if( button !== 'showTop' ) {
                    classie.toggle( showTop, 'disabled' );
                }
                if( button !== 'showBottom' ) {
                    classie.toggle( showBottom, 'disabled' );
                }
                if( button !== 'showLeftPush' ) {
                    classie.toggle( showLeftPush, 'disabled' );
                }
                if( button !== 'showRightPush' ) {
                    classie.toggle( showRightPush, 'disabled' );
                    /*var vla=$('.cbp-spmenu-vertical').width()
                    $('#sub-header').css('margin-left',-val);*/
                }
            }
        });
    
    </script>

  <?php } ?>



  <?php

    if(isset($_POST['change_budget'])){
        echo "<script> alert('Budget Changed!'); </script>";
    }

    if(isset($_POST['submit_update_prices'])){
        echo "<script> alert('Prices updated!'); </script>";
    }

    if(isset($_POST['submit_proposal'])){
        $client_name = $_POST['client_name'];
        $client_phone = $_POST['client_phone'];
        $email = $_POST['email'];
        $delivery_address = $_POST['delivery_address'];
        $category_list = "";
        if(isset($_SESSION['categories'])){
            $category_list = $_SESSION['categories'];
        }

        $from_name = "Drinks.ng";
        $from_mail = "info@drinks.ng";

        $response = get_email_proposal($category_list, "auto");
        $body = $response;

        $headers = "From: ".$from_name." <".$from_mail.">\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";

        $to = $email;
        $subject = 'Drinks calculations from Drinks.ng';

        //echo $response;
        

        if(wp_mail( $to, $subject, $body, $headers )){
            echo "<script> alert('Mail sent to client!'); </script>";
        }
    }

  ?>




</body>
</html>