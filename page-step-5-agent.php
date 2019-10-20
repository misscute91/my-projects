<?php
/**
 * Template Name: Step 5 Agent

 */

$_SESSION['LAST_PAGE_VISITED'] = $pagename;

get_header(); ?>

<?php

unset($_SESSION['updated_items']);
unset($_SESSION['updated_others']);

if(isset($_POST['submit_update_prices'])){

    $items = array();
    $others = array();
    $i = 0;
    $j= 0;
    foreach($_POST as $key => $value){
        $value = str_replace(",", "", (string)$value);
        // echo $key . " " . $value; 
        // echo "<br>";
        if($key != "submit_update_prices" ){
            if(strpos($key, "item") !== false){
                $items[$i] = $value;
                $i++;
            }
            if(strpos($key, "others") !== false){
                $others[$j] = $value;
                $j++;
            }
        }
    }
    $_SESSION['updated_items'] = $items;
    $_SESSION['updated_others'] = $others;
}

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

$total = "";
$query = "";
$total = "";
$query = "";
$page = 0;
$offset = 0;
$result = "";
$items_per_page = 100;

?>

<header class="mobile-step-nav">
      <div class="container-fluid">
        <div class="row">
            <a href="<?php echo get_site_url(); ?>/step-four" class="btn secondry">prev</a>
            <h3 class="title"><span>5</span> Place Order</h3>
            
        </div>
       </div>
    </header>

    
    <section class="main-pro-container main-price-table">
        <div class="container-fluid">
            <div class="row step-cont text-center ">
            <div class="col-lg-3 step prev">
                <h2 class="title step-count">1</h2>
                <p>Enter your Details</p>
            </div>
            
            <div class="col-lg-3 step prev">
                <h2 class="title step-count">2</h2>
                <p>Get a Quote for Drinks</p>
            </div>
                
            <div class="col-lg-3 step prev">
                <h2 class="title step-count">3</h2>
                <p>Select Quantities of Drinks</p>
            </div>
                
            <div class="col-lg-3 step prev">
                <h2 class="title step-count">4</h2>
                <p>Place your order</p>
            </div>
            
            <div class="col-lg-3 step active">
                <h2 class="title step-count">5</h2>
                <p>Pay</p>
            </div>
                    
                
            </div>   
                
            <div class="row">
                <div class="col-xl-9 col-lg-12">
            
                <form action="" method="post" >
                <div class="pro-content basket-cont">
                    
                    <div class="row">
                        <div class="col-12">
                        <div class="basket">
                
                    <div class="top-sec text-left">
                    <div class="pull-left col">
                        <?php 
                        $budjet = 0;
                        $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
                        ?>
                        <p class="budget-label">Budget</p>
                        <h3 class="title budget">₦<?php echo str_replace(".00", "", number_format((float)$budjet,2,".",",")); ?></h3>
                        <a href="<?php echo get_site_url(); ?>">Change Budget</a>
                    </div>
                    <div class="pull-left col event-count">
                        <h3 class="title guest"><?php if(!isset($_SESSION['no_of_guest'])) { echo "0"; } else { echo @$_SESSION['no_of_guest']; } ?></h3>
                        <p><small>Number of guests</small></p>
                        </div>
                        
                    <div class="pull-left col event-type">
                        <h3 class="title guest"><?php echo @$_SESSION['event_type']; ?></h3>
                        <p><small>Event Type</small></p>
                    </div>
                        
                    <div class="pull-left col event-date">
                        <?php
                            $event_date = date("jS F Y", strtotime(@$_SESSION['event_date']));
                        ?>
                        <h3 class="title guest"><?php echo $event_date; ?></h3>
                        <p><small>Event date</small></p>
                    </div>
                        
                      
                      <div class="dropdown pull-right">
                      <a href="<?php echo get_site_url(); ?>/step-two" class="btn primary" >Add more products or services</a>  
                       
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="<?php echo get_site_url(); ?>/step-three">Products</a>
    <a class="dropdown-item" href="<?php echo get_site_url(); ?>/step-four">Services</a>
  </div>
                        </div>
                        
                    </div>
                                
                        <div class="main-content ">
                            
                        <div class="row">
                            <div class="col-xl-8 col-lg-8">
                        
                        <h4 class="basket-label">Drinks </h4>

                       
                        <?php
                        // code to dislay here
                        $grand_total = 0;

        if(isset($_SESSION['product_basket'])){

        $categories  = array(); 
        for($i=0,$j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
            if(!in_array($_SESSION['product_basket']['product'][$i]['category_name'], $categories)){
                if($_SESSION['product_basket']['product'][$i]['category_name'] != "other services" && 
                    $_SESSION['product_basket']['product'][$i]['category_name'] != "vendors"){
                    $categories[$j] = $_SESSION['product_basket']['product'][$i]['category_name'];
                    $j++;
                }
            }
        }

        $_SESSION['categories'] = $categories;


        $basket = "";
        $incr = 0;
        
        for($i=0; $i<sizeof($categories); $i++){

                $basket .= "<div id='cat-id' class='pro-cat'>";

                $sub_total = 0;
                $carton_total = 0;
                $match = false;
                $inner_basket = "";
                $units = 0;
                

                for($j=sizeof($_SESSION['product_basket']['product'])-1; $j>=0; $j--){
                    if($categories[$i] == $_SESSION['product_basket']['product'][$j]['category_name'] && $_SESSION['product_basket']['product'][$j]['name'] != ""){

                        $match = true;
                        $btl = $_SESSION['product_basket']['product'][$j]['bottle']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['bottle']) == true){ $btl = 0; }
                        $carton = $_SESSION['product_basket']['product'][$j]['carton']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['carton']) == true){ $carton = 0; }
                        $carton = @intval($btl / $carton);
                        $carton_total += $carton;

                        $item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_items'])){ 
                            if(isset($_SESSION['updated_items'][$incr])){
                                $item_val = $_SESSION['updated_items'][$incr];
                            }
                        }

                        $inner_basket .= "<div class='pro-list'>";
                        $inner_basket .= "<p class='name'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                        //$inner_basket .= "<p class='carton'>". $carton ."<small>cartons</small></p>";
                        $inner_basket .= "<p class='carton'>&nbsp;<small>&nbsp;</small></p>";

                        $units_text_ = ((int) $_SESSION['product_basket']['product'][$j]['bottle'] > 1) ? "units" : "unit";
                        $inner_basket .= "<p class='unit'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."<small>$units_text_</small></p>";
                        
                        $inner_basket .= "<p class='unit-price unit'>"
                        . str_replace(".00", "", number_format((float)$_SESSION['product_basket']['product'][$j]['price'],2,".",",")) ."<small>units price</small></p>";

                        $inner_basket .= "<p class='total unit'><input type='text' name='item-$j' class='form-control dark-border' value='". str_replace(".00", "", number_format((float)$item_val,2,".",",")) ."' required /><small>Total</small></p>";
                        $inner_basket .= "</div>";
                        $sub_total += (int) $item_val;
                        $units += (int) $_SESSION['product_basket']['product'][$j]['bottle'];
                        $incr++;
                    }
                }
                // <span class='pull-right' style='opacity:0'>" . $carton_total . " CTN</span>
                // <span class='pull-right'>" . $carton_total . " Cartons</span>

                $units_text = ($units > 1) ? "Units" : "Unit";

                $basket .= "<h4 class='title sup-title'><span>". str_replace("-", " ", $categories[$i]) ."</span>
                            <span class='pull-right'>₦" . str_replace(".00", "", number_format((float)$sub_total,2,".",",")) . " Total</span>
                            <span class='pull-right'>" . $units . " $units_text </span>
                            </h4>";

                if($match == true) $basket .= $inner_basket;
                $basket .= "</div><hr />";
                $grand_total += $sub_total;
        }

        echo $basket;

        }

        ?>



                            </div>
                            
                            
                             <div class="col-xl-4 col-lg-4">
                        <div class="service-list">
                    <h4 class="basket-label">Other Services</h4>
                        
                    <div id="cat-id" class="pro-cat">
                    <h4 class="title sup-title">
                        <span>Service </span>
                        <span>Units</span>
                        <span>Estimated Cost</span> 

                        <?php
        if(isset($_SESSION['product_basket'])){

         $otherservices = "";
         $incr = 0;
        
        for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                if($_SESSION['product_basket']['product'][$j]['category_name'] == "other services"){

                    $item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_others'])){
                            if(isset($_SESSION['updated_others'][$incr])){
                                $item_val = $_SESSION['updated_others'][$incr];
                            }
                        }

                    $otherservices .= "<div class='pro-list'>";
                    $otherservices .= "<p class='name'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                    $otherservices .= "<p class='unit'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."</p>";
                    $otherservices .= "<p class='unit'><input type='text' name='others-$j' class='form-control' value='" . str_replace(".00", "", number_format((float)$item_val,2,".",",")) . "' required /></p>";
                    $otherservices .= "</div>";
                    $grand_total += (int)$item_val;
                    $incr++;
                }
        }

        echo $otherservices;

        }

                        ?>

                        </div>

                        <?php if(isset($_SESSION['selected_vendor'])){ ?>
                        <div id="cat-id" class="pro-cat">
                                <h4 class="title sup-title">
                                <h3 class="vendor-sel-title">Vendor Selected </h3>
                                <p class="vendor-sel"><?php echo $_SESSION['selected_vendor']; ?></p>
                                </h4>
                        </div>
                        <?php } ?>
                        
                        </div>
                        </div>
                            
                            
                        </div>
                            
                            
                        </div>    
                        
                        
                        <div class="footer text-right">
                        <!-- <button type="submit" name="updateprices" class="primary btn pull-left">Update Prices</button> -->
                            
                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>/step-five" >
                    <div class="pull-left">
                    <button type="submit" name="submit_update_prices" class="primary btn pull-left" style="z-index: 9999;">Update Prices</button>
                    <p class="update-prices-text"></p></div>


                    <h3 class="title" style="z-index: 8888;">₦<?php echo str_replace(".00", "", number_format((float)$grand_total,2,".",",")) ?></h3>
                        <h4>Total Spent</h4>
                    </div>
                            
                    </div>
                    </div>
                </div>
                </div>
                </form>
                    
                    
                </div>
                
                
                <div class="col-xl-3 col-lg-4 payment-option">
                    
                    <form class="row" action="" method="post">
                        <h4 class="title col-12 text-left ">Payment</h4>
                        <p class="col-12 text-left"><small>We will provide you with a more accurate price after your vehicle inspection at any of our Inspection Centers.</small></p>

                         <label class="col-12"><input type="text" name="client_name" class="form-control" placeholder="Client Name" required /></label>
                    <label class="col-12"><input type="text" name="client_phone" class="form-control" placeholder="Client Phone" required /></label>
                    <label class="col-12"><input type="email" name="email" class="form-control" placeholder="Client Email" required /></label>
                        <label class="col-12"><textarea name="delivery_address" class="form-control" placeholder="Delivery Address" required ></textarea></label>
                        
                        <div class="col-12">
                            <button class="btn btn-block secondry" data-toggle="modal" data-target="#proposalModal" type="button"><span>View Proposal</span></button>
                            
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" name="submit_proposal" class="btn btn-block default"><span>Send Proposal</span></button>
                            
                        </div>
                        
                        
                        <!--div class="col-12">
                            <button class="btn btn-block pay-with-card"><span>pay with card <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.  </p></span></button>
                            
                        </div>
                        
                        <div class="col-12">
                            <button class="btn btn-block pay-with-card"><span>pay with card <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.  </p></span></button>
                            
                        </div-->
                        
                    </form>
            </div>
                
                
            </div>


            <div class="row">
               <div class="col-12 mobile-next-btn finish-btn"> <a href="#payment" class="btn secondry btn-block" data-toggle="modal" data-target="#payment" class="btn btn-next btn-block">Proceed to payment</a></div>
            </div>
                
                
            </div>
            </div>
            
             </section>
    


<div class="modal main-pro-container" tabindex="-1" role="dialog" id="payment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          <form action="" method="post" class="col-12">
                        <h4 class="title col-12 text-left ">Payment</h4>
                        <p class="col-12 text-left"><small>We will provide you with a more accurate price after your vehicle inspection at any of our Inspection Centers.</small></p>
                    <label class="col-12"><input type="text" name="client_name" class="form-control" placeholder="Client Name" required /></label>
                    <label class="col-12"><input type="text" name="client_phone" class="form-control" placeholder="Client Phone" required /></label>
                       <label class="col-12"><textarea name="delivery_address" class="form-control" placeholder="Delivery Address" required ></textarea></label>
                       <input type="hidden" name="category_list"  value="<?php if(isset($categories)){ echo $$categories; } ?>" />

                       <div class="col-12">
                            
                            <button class="btn btn-block secondry" data-toggle="modal" data-target="#proposalModal" type="button"><span>View Proposal</span></button>
                            
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" name="submit_proposal" class="btn btn-block default"><span>Send Proposal</span></button>
                            
                        </div>
                       
                    </form>
          
      </div>
      
    </div>
  </div>
</div>




<div class="modal fade view-prop" id="proposalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          
             <?php echo get_proposal($categories, "100%"); ?>
                 
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    


<?php  get_footer(); ?>

<script>
          $.ajax({
                type: 'GET',
                url: "<?php echo get_site_url(); ?>/ajax-pay-order",
                contentType: "application/json; charset=utf-8",
                data:{
                    client_name: "",
                    client_phone: "",
                    delivery_address: "",
                    pay: "2"
                },
                success: function (data){
                    
                }
            });
</script>