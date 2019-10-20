<?php

/**
 * Template Name: Step 2

 */

$_SESSION['LAST_PAGE_VISITED'] = $pagename;

get_header(); ?>

<?php

$selected_bottles = array();

?>

<?php

// Get no of lowest product prices by category
set_minimum_prices();
set_party_calculations();

?>

<?php
$session_budget = 0;
if(isset($_SESSION['budget'])){
    $session_budget = $_SESSION['budget'];
}
?>

<!-- Hidden fields -->
<input type="hidden" id="budget" value="<?php echo $session_budget; ?>">

<!-- Hidden fields -->


<?php
// categories check

if(isset($_SESSION['product_basket'])){

for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
    $str = str_replace("-"," ", $_SESSION['product_basket']['product'][$i]['category_name']);
    $category_exist = false;

    if(isset($_SESSION['basket'])){
        for($j=0; $j<sizeof($_SESSION['basket']['category']); $j++){
            $str_ = str_replace("-"," ", $_SESSION['basket']['category'][$j]['name']);
            if($str_ == $str){
                $category_exist = true;
            }
        }
    }

    if($category_exist == false){
        $category_info = array(
            "name" => $str,
            "minprice" => 0,
            "bottle" => 0
        );
        $_SESSION['basket']['category'][sizeof(@$_SESSION['basket']['category'])] = $category_info;
    }
}

}



?>

<header class="mobile-step-nav">
      <div class="container-fluid">
        <div class="row">
            <a href="<?php echo get_site_url(); ?>" class="btn secondry">prev</a>
            <h3 class="title"><span>2</span> Order a Service</h3>
            <a href="<?php echo get_site_url(); ?>/step-three" class="btn secondry">next</a>
        </div>
       </div>
    </header>


<section class="main-pro-container">
        <div class="container-fluid">

        <!-- <div class="row details-btn-cont">
                <div class="col-12"><a href="#view-basket" class="btn secondry btn-block" data-toggle="modal" data-target="#view-basket">View Basket</a></div>
        </div> -->


            <div class="row step-cont text-center ">
            <div class="col-lg-3 step prev">
                <h2 class="title step-count">1</h2>
                <p>Enter your Details </p>
            </div>
            
            <div class="col-lg-3 step active">
                <h2 class="title step-count">2</h2>
                <p>Get a Quote for Drinks</p>
            </div>
               
            </div>
            
            <div class="row">
               
                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="pro-content">
                <div class="row">
                    <div class="col-12 prod-title other-serv">
                        <a href="<?php echo get_site_url(); ?>" class="back-btn btn secondry pull-left">back</a>
                    <h4 class="main-title pull-left title">Drink Categories</h4>
                    <p>&nbsp;&nbsp; <br/><br/> This is where you pick the categories and it will tell you how many you will need based on your budget and number of guests</p>
                    <hr />
                    </div>

<?php

$total_amount_incured = 0;

$args = array(
    'number'     => @$number,
    'orderby'    => @$orderby,
    'order'      => @$order,
    'hide_empty' => @$hide_empty,
    'include'    => @$ids
);

$product_categories = get_terms( 'product_cat', $args);
$i = 0;
$incr = 0;



foreach( $product_categories as $cat ) {

        $min_price = 0;
        $min_price_formatted = "";
        if(isset($_SESSION[$cat->slug . "-price"])){
            $min_price = $_SESSION[$cat->slug . "-price"];
            $min_price_formatted = number_format((float)$_SESSION[$cat->slug . "-price"]);
        }


    if($cat->name != "other services" && $cat->name != "vendors"){
        $cat_thumb_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $cat_thumb_url = wp_get_attachment_thumb_url( $cat_thumb_id );


        $no_of_bottle = 0;  if(get_term_meta($cat->term_id, 'wh_meta_no_of_people', true) != "") $no_of_bottle = get_term_meta($cat->term_id, 'wh_meta_no_of_bottle', true);
        $no_of_people = 0;  if(get_term_meta($cat->term_id, 'wh_meta_no_of_people', true) != "") $no_of_people = get_term_meta($cat->term_id, 'wh_meta_no_of_people', true);

        
        $allowed_qty = 0;
        // check bottle
        if($no_of_bottle > 0 && $no_of_people > 0) {

                if(strlen((string)$no_of_people) > 1  ){

                    $num = (double)$no_of_bottle / (double)$no_of_people;
                    $divisor = (double)@$_SESSION['no_of_guest'] / (double)$num;
                    $allowed_qty = (int)ceil($divisor);

                } else {

                    $allowed_qty  = (int)@$_SESSION['no_of_guest'] / (double)$no_of_people;
                    $allowed_qty  = (int)ceil($allowed_qty);
                    $allowed_qty  = $allowed_qty * $no_of_bottle;
                }

                // if(strlen($no_of_people) > 1){
                //     $no_of_guest = (int)@$_SESSION['no_of_guest'];
                //     $no_of_people = (double)$no_of_people; 

                //     $allowed_qty = $no_of_guest * $no_of_people;
                //     $allowed_qty = (int)ceil($allowed_qty);
                // } else {
                //     $allowed_qty  = (int)@$_SESSION['no_of_guest'] / (int)$no_of_people;
                //     $allowed_qty  = (int)ceil($allowed_qty);
                //     $allowed_qty  = $allowed_qty * $no_of_bottle;
                // }


                $catdata = array();
                $catdata[0] = $cat->slug;
                $catdata[1] = $allowed_qty;
                $selected_bottles[$incr] = $catdata;
                $incr++;
        }
        
        // basket session parameters
        $active = "";
        if(isset($_SESSION['basket'])){
            for($i=0; $i<sizeof($_SESSION['basket']['category']); $i++){
                $str = str_replace("-"," ", $_SESSION['basket']['category'][$i]['name']);
                if(strtolower($str) == strtolower($cat->name)){
                    $active = "active";
                } 
            }

        } 

        

        if($active != ""){
            $total_amount_incured += $allowed_qty * $min_price;
        }


        $bottle = "Bottle";
        if($allowed_qty > 1) $bottle = "Bottles";

        

?>

                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-xs-6 prod-cont serv-cont add<?php echo $cat->term_id; ?> remove<?php echo $cat->term_id; ?> addplus<?php echo $cat->term_id; ?> substract<?php echo $cat->term_id; ?> qtyinput<?php echo $cat->term_id; ?>">
                    <div class="prod <?php echo $active; ?>">
                        <h5 class="title pro-name"><?php echo ucwords($cat->name); ?></h5>
                        
                        <img src="<?php echo $cat_thumb_url; ?>" class="pro-img" alt="" />
                        
                        <span class="pro-cost <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>"><?php echo str_replace(".00", "", number_format((float)$allowed_qty,2,".",",")) . " " . $bottle; ?> </span>

                        <br/>
                        <span class="control">
                            <a href="" class="add-prod <?php if($active == "active"){ echo "hide-element"; } else { echo "show-element"; } ?>" id="add<?php echo $cat->term_id; ?>" >add</a>
                            <a href="" class="remove <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="remove<?php echo $cat->term_id; ?>">x</a>

                            <!--<a href="" class="addplus <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="addplus<?php echo $cat->term_id; ?>">+</a>
                            <input type="text" id="qtyinput<?php echo $cat->term_id; ?>" class="allowed_qty allow_numbers_only <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" value="<?php echo $allowed_qty; ?>" /> 
                            <a href="" class="substract <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="substract<?php echo $cat->term_id; ?>">-</a>-->
                        </span>

                        <input type="hidden" id="price" value="<?php echo $min_price; ?>">
                        <input type="hidden" id="category_name" value="<?php echo $cat->slug; ?>">
                        
                    </div>
                    </div>

<?php

} }


$_SESSION['selected_bottles'] = $selected_bottles;

?>


                    
                    
                    <div class="col-lg-12 prod-title basket-cont">
                    <hr />
                    <a href="<?php echo get_site_url(); ?>/step-three" class="btn btn-next btn-block">Next</a>
                    </div>

                    
                    

                    
                    
                    
                    
                 </div>   
                </div>
                </div>
                
                <!--
                <div class="col-xl-3 col-lg-4 basket-cont">
                <div class="basket">
                
                    <div class="top-sec text-center">
                    
                        <p class="budget-label">Budget</p>
                        <?php 
                        $budjet = 0;
                        $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
                        ?>
                        <h3 class="title budget">₦<?php echo str_replace(".00", "", number_format($budjet,2,".",",")); ?></h3>
                        <a href="#" id="x-change-budget" >Change Budget</a>
                        <h3 class="title guest"><?php if(!isset($_SESSION['no_of_guest'])) { echo "0"; } else { echo @$_SESSION['no_of_guest']; } ?></h3>
                        <p><small>Number of guests</small></p>
                    </div>
                    
                    <div class="whole-cont">
                     <h4 class="basket-label"><i></i>Basket <a href="" id="empty_basket" class="pull-right"><small>Empty Basket</small></a></h4>
                    <div class="main-content">

                        <?php

                    $total = 0;
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

                        ?>
                    
                        
                    </div>
                    </div>
                    
                    <div class="footer text-right">
                    <h3 class="title">₦<?php echo $total; ?></h3>
                        <h4>Total Spent</h4>
                    </div>
                    
                    
                </div>
                    
                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>/step-two" >
                    <input type="hidden" id="total_amount_incured" value="<?php echo $total_amount_incured; ?>" >

                    <!--div class="notice">1% will be charged by drink.ng for every trasaction that takes place on the site</div-->
                    <!--<a href="<?php echo get_site_url(); ?>/step-three" class="btn btn-next btn-block">Next</a>
            </div>
            </div>-->


            
                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>/step-two" >
                    <input type="hidden" id="total_amount_incured" value="<?php echo $total_amount_incured; ?>" >
            
        </div>

         <div class="row">
               <div class="col-12 mobile-next-btn"> <a href="<?php echo get_site_url(); ?>/step-three" class="btn btn-next btn-block">Next</a></div>
         </div>
    </section>




<?php  get_footer(); ?>


<?php if(isset($_POST['submit'])){ ?>
<script>
          $.ajax({
                type: 'GET',
                url: "<?php echo get_site_url(); ?>/ajax-pay-order",
                contentType: "application/json; charset=utf-8",
                data:{
                    client_name: "",
                    client_phone: "",
                    delivery_address: "",
                    pay: "1"
                },
                success: function (data){
                    
                }
            });
</script>
<?php } ?>


<?php

if(isset($_POST['submit'])){
    subscribe_to_mailchimp(@$_POST['email']);
}

?>
