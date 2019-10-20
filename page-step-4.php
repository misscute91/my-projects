<?php
/**
 * Template Name: Step 4

 */

$_SESSION['LAST_PAGE_VISITED'] = $pagename;

get_header(); ?>

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
            <a href="<?php echo get_site_url(); ?>/step-three" class="btn secondry">prev</a>
            <h3 class="title"><span>4</span> Order Services</h3>
            <a href="<?php echo get_site_url(); ?>/step-five" class="btn secondry">next</a>
        </div>
       </div>
    </header>

    
    <section class="main-pro-container services">
        <div class="container-fluid">

            <div class="row details-btn-cont">
                <div class="col-12"><a href="#view-basket" class="btn secondry btn-block" data-toggle="modal" data-target="#view-basket">View Basket</a></div>
            </div>


            <div class="row step-cont text-center ">
            <div class="col-lg-2 step prev">
                <h2 class="title step-count">1</h2>
                <p> Enter your Details </p>
            </div>
            
            <div class="col-lg-2 step prev">
                <h2 class="title step-count">2</h2>
                <p>Get a Quote for Drinks</p>
            </div>
                
            <div class="col-lg-2 step prev">
                <h2 class="title step-count">3</h2>
                <p>Select Quantities of Drinks</p>
            </div>
                
            <div class="col-lg-2 step active">
                <h2 class="title step-count">4</h2>
                <p>Place your order</p>
            </div>
                
            </div>
            
            <div class="row">
               
                
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="pro-content">
                <div class="row">
                    <div class="col-lg-12 prod-title other-serv">
                        <a href="<?php echo get_site_url(); ?>/step-three" class="back-btn">back</a>
                    <h4 class="main-title pull-left title">Other Services</h4>
                    <hr />
                    </div>

<!-- show vendor only -->
<?php
$query_vendor = "
SELECT p.ID
FROM wp_posts p
LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
LEFT JOIN wp_terms t ON t.term_id = tax.term_id
WHERE t.slug = 'vendors' ";
$result_vendor = $wpdb->get_results( $query_vendor . " ORDER BY p.ID" );

            foreach($result_vendor as $res){
                $postid = $res->ID;
                $title  = get_the_title( $postid );
                $product = get_post( $postid ); 
                $price = get_post_meta( $postid, '_regular_price', true);
                $slug = $product->post_name;
                $feat_image = wp_get_attachment_url( get_post_thumbnail_id($postid) );
                $term_list = wp_get_post_terms($postid,'product_cat',array('fields'=>'names'));
                $catname = $term_list[0];
                $bottle_input = 1;

                $active = "";
                    if(isset($_SESSION['product_basket'])){
                        for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
                            if($_SESSION['product_basket']['product'][$i]['name'] == $title){
                                $active = "active";
                                $bottle_input = $_SESSION['product_basket']['product'][$i]['bottle'];
                            }
                        }
                    }
                // basket session parameters
                $item_total = $price;
?>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-6 prod-cont serv-cont vendor_add vendor<?php echo $postid; ?> add<?php echo $postid; ?> remove<?php echo $postid; ?> add-prod<?php echo $postid; ?> substract<?php echo $postid; ?>">
                    <div class="prod <?php echo $active; ?>">
                        <h5 class="title pro-name"><?php echo ucwords($title); ?></h5>
                        <h4 class="title pro-amount">₦ <?php echo str_replace(".00", "", number_format((float)$price,2,".",",")); ?></h4>
                        <img src="<?php echo $feat_image; ?>" class="pro-img" alt="" />

                        <span class="vendor-name <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>">
                        <?php if(isset($_SESSION['selected_vendor'])){ echo $_SESSION['selected_vendor']; } else { echo "Vendor Name"; } ?>
                        </span>
                        <input type="hidden" id="cost" value="<?php echo $price; ?>">

                        <br/>
                        <span class="control">
                        <a href="" id="vendor<?php echo $postid; ?>" class="add-prod <?php if($active == "active"){ echo "hide-element"; } else { echo "show-element"; } ?>" data-toggle="modal" data-target="#vendorModal">add</a>
                        <a href="" id="vendor<?php echo $postid; ?>" class="add-prod change-vendor <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" data-toggle="modal" data-target="#vendorModal">CHANGE VENDOR</a>
                        <a href="" class="remove <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="remove<?php echo $postid; ?>">x</a>
                        </span>

                        <span class="meta-data">
                        <!-- <p class="carton"><span>12</span> Cartons</p> -->
                        <input type="hidden" id="bottle_input" value="<?php echo $bottle_input; ?>">
                        </span>

                        <input type="hidden" id="price" value="<?php echo $price; ?>">
                        <input type="hidden" id="category_name" value="<?php echo strtolower($catname); ?>">
                        <input type="hidden" id="product_name" value="<?php echo $title; ?>">
                    </div>
                    </div>

<?php } ?>










<?php 

// searching by category

$category_slug = "other-services";
$total = $wpdb->get_var("
SELECT COUNT(*)
FROM wp_posts p
LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
LEFT JOIN wp_terms t ON t.term_id = tax.term_id
WHERE t.slug = '" . $category_slug . "' ");

$query = "
SELECT p.ID
FROM wp_posts p
LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
LEFT JOIN wp_terms t ON t.term_id = tax.term_id
WHERE t.slug = '" . $category_slug . "'";

$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$result = $wpdb->get_results( $query . " ORDER BY p.ID LIMIT ${offset}, ${items_per_page}" );


?>


<!-- the loop for products without category -->
<?php 
            foreach($result as $res){
                $postid = $res->ID;
                $title  = get_the_title( $postid );
                $product = get_post( $postid ); 
                $price = get_post_meta( $postid, '_sale_price', true);
                $slug = $product->post_name;
                $feat_image = wp_get_attachment_url( get_post_thumbnail_id($postid) );

                $term_list = wp_get_post_terms($postid,'product_cat',array('fields'=>'names'));
                $catname = $term_list[0];

                    // basket session parameters
                    $item_total = $price;
                    $bottle_input = 1;
                    $active = "";
                    if(isset($_SESSION['product_basket'])){
                        for($i=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
                            if($_SESSION['product_basket']['product'][$i]['name'] == $title){
                                $active = "active";
                                $bottle_input = $_SESSION['product_basket']['product'][$i]['bottle'];
                                $item_total = $_SESSION['product_basket']['product'][$i]['total'];
                            }
                        }
                    }

?>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-6 prod-cont serv-cont add<?php echo $postid; ?> remove<?php echo $postid; ?> add-prod<?php echo $postid; ?> substract<?php echo $postid; ?> add-input<?php echo $postid; ?>">
                    <div class="prod <?php echo $active; ?>">
                        <h5 class="title pro-name"><?php echo ucwords($title); ?></h5>
                        <h4 class="title pro-amount">₦ <?php echo str_replace(".00", "", number_format((float)$price,2,".",",")); ?></h4>
                        <img src="<?php echo $feat_image; ?>" class="pro-img" alt="" />

                        <span class="pro-cost <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>">
                        N <?php echo str_replace(".00", "", number_format((float)$item_total,2,".",",")); ?>
                        </span>
                        <input type="hidden" id="cost" value="<?php echo $price; ?>">

                        <br/>

                        
                        <span class="control">
                        <a href="" class="add-prod <?php if($active == "active"){ echo "hide-element"; } else { echo "show-element"; } ?>" id="add-prod<?php echo $postid; ?>" >add</a>
                        
                        <?php  if(strtolower($title) != "delivery"){ ?>
                        <a href="" class="add <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="add<?php echo $postid; ?>">+</a>
                        <input class="add-input  <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="add-input<?php echo $postid; ?>" type="text" value="<?php echo $bottle_input; ?>"/>
                        <a href="" class="substract <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="substract<?php echo $postid; ?>">-</a>
                        <?php } ?>

                        <a href="" class="remove <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="remove<?php echo $postid; ?>">x</a>
                        </span>


                        <span class="meta-data">
                        <!-- <p class="carton"><span>12</span> Cartons</p> -->
                        <p class="bottle services-bottle <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>"><span><?php echo $bottle_input; ?></span> <?php echo ucwords($title); ?></p>
                        <input type="hidden" id="bottle_input" value="<?php echo $bottle_input; ?>">
                        </span>

                        <input type="hidden" id="price" value="<?php echo $price; ?>">
                        <input type="hidden" id="category_name" value="<?php echo strtolower($catname); ?>">
                        <input type="hidden" id="product_name" value="<?php echo $title; ?>">
                    </div>
                    </div>

                    
                    
<?php } ?>


<?php if(sizeof($result) == 0){ ?>
<h5 class="title pro-name">No Products Found</h5>
<?php } ?>
                    
                    
                    
                    <div class="col-lg-12 prod-title">
                    <hr />
                    </div>
                    
                    
                    
                    
                 </div>   
                </div>
                </div>
                
                
                <div class="col-xl-3 col-lg-4 basket-cont">
                <div class="basket">
                
                    <div class="top-sec text-center">
                    
                        <p class="budget-label">Budget</p>
                        <?php 
                        $budjet = 0;
                        $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
                        ?>
                        <h3 class="title budget">₦<?php echo str_replace(".00", "", number_format((float)$budjet,2,".",",")); ?></h3>
                        <a href="#" id="x-change-budget" >Change Budget</a>
                        <h3 class="title guest"><?php if(!isset($_SESSION['no_of_guest'])) { echo "0"; } else { echo @$_SESSION['no_of_guest']; } ?></h3>
                        <p><small>Number of guests</small></p>
                    </div>
                    
                    <div class="whole-cont">
                     <h4 class="basket-label"><i></i>Basket <a href="" id="empty_basket" class="pull-right"><small>Empty Basket</small></a></h4>
                    <div class="main-content">

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
        
        for($i=sizeof($categories)-1; $i>=0; $i--){
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
                    // $inner_basket .= "<p class='carton'>". $carton ."<small>cartons</small></p>";
                    $inner_basket .= "<p class='carton'>&nbsp;<small>&nbsp;</small></p>";
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

        echo $basket;

        }

        ?>
                    
                   
                  
                    </div>
                    </div>
                    
                    
                    <div class="footer text-right">
                    <h3 class="title">₦<?php echo str_replace(".00", "", number_format((float)$product_total,2,".",",")); ?></h3>
                        <h4>Total Spent</h4>
                    </div>
                </div>


                    
                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>/step-four" >

                    <input type="hidden" id="total_incur_product" value="<?php echo $product_total; ?>" >

                    <!--div class="notice">1% will be charged by drink.ng for every trasaction that takes place on the site</div-->
                    <a href="<?php echo get_site_url(); ?>/step-five" class="btn btn-next btn-block">Next</a>
            </div>
            </div>

            <div class="row">
               <div class="col-12 mobile-next-btn"> <a href="<?php echo get_site_url(); ?>/step-five" class="btn btn-next btn-block">Next</a></div>
            </div>

            
        </div>
    </section>





<div class="modal fade vendors-list" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select a Drinks Vendor name and Click on Save Changes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<?php
if(!isset($_SESSION['state_name'])){
    echo "<p>Please select a state in Step 1 </p>";
}
?>    
        <select class="form-control" id="vendor_select" multiple>
  <?php

$vendors = "";
$args = array(
    'role'    => 'vendors',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users( $args );
if(isset($_SESSION['state_name'])){
    foreach ( $users as $user ) {
        $cname = get_user_meta( $user->ID, 'company_name', true );
        $state = get_user_meta( $user->ID, 'billing_state', true );
        
            if($state == $_SESSION['state_name']){
                $vendors .= "<option value='" . ucwords($cname) . "'>" . ucwords($cname) . "</option>";
            } 
    }
} 

echo $vendors;
?>

</select>
<?php if($vendors == ""){ echo "<p>No vendor found</p>"; } ?>

<div class="vendor_list">
<p>This vendor list is based on the state you selected </p>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
        <button type="button" id="vendor_submit" class="btn primary">Save changes</button>
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