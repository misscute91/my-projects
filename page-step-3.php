<?php

/**
 * Template Name: Step 3

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
// fetch category ids
$category_ids = fetch_categories_ids_step();

print_r($category_ids); 
echo "hello";

$_SESSION['total_incur_product'] = 0;

$first_product = array();
$first_product_name = "";
$product_cat_id = 0;
if(isset($_GET['product_cat'])){
    $category_ = get_term_by( 'slug', $_GET['product_cat'], 'product_cat' );
    $product_cat_id = $category_->term_id;
}


?>




<?php

if(isset($_SESSION['basket'])){

    // Code for setting all category names into product basket
    $products = array();
    $len = 0;
    if(isset($_SESSION['product_basket'])){
        $len = sizeof($_SESSION['product_basket']['product']);
        $products = $_SESSION['product_basket']['product'];
    }


    for($i=0; $i<sizeof($_SESSION['basket']['category']); $i++){  

        $str = str_replace("-", " ", $_SESSION['basket']['category'][$i]['name']);
        $found = false;

        if(isset($_SESSION['product_basket'])){
            for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                $str_ = str_replace("-", " ", $_SESSION['product_basket']['product'][$j]['category_name']);
                if($str == $str_){
                    $found = true;
                }
            }
        }

        if($found == false){
            $product_info = array(
                    "name" => "",
                    "price" => 0,
                    "bottle" => 0,
                    "category_name" => $_SESSION['basket']['category'][$i]['name'],
                    "total" => 0
            );
            $products[$len] = $product_info;
            $len++;
        }
    }

    $basket = array(
        "budget" => @$_SESSION['budget'],
        "balance" => 0,
        "product" => $products
    );
    $_SESSION['product_basket'] = $basket;
}

?>

<?php

$total = "";
$query = "";
$total = "";
$query = "";
$page = 0;
$offset = 0;
$result = "";
$items_per_page = 8;
$num_to_remove = 0;

?>



<!-- search Param starts here -->

<?php 

// code for query without category
$search_param = "";
if(isset($_POST['search_input'])){
    $search_param .= " AND wp_posts.post_title LIKE '%" . $_POST['search_input'] . "%'";
}

if(isset($_SESSION['total']) && isset($_SESSION['query']) && isset($_SESSION['q'])  && $_GET['q'] == 1){        

$total = $_SESSION['total'];
$query = $_SESSION['query'];
$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$result = $wpdb->get_results( $query . $append_query); 

    if($_SESSION['query_by_category'] != true){
        $result = $wpdb->get_results( $query . " ORDER BY ID DESC LIMIT ${offset}, ${items_per_page}" ); 
    } else {
        $result = $wpdb->get_results( $query . " ORDER BY p.ID DESC LIMIT ${offset}, ${items_per_page}" ); 
    }

} else {

/** No Parameter Given **/

if(!isset($_GET['product_cat'])){

/* This Works, but I changed it to only select the first Category on the list */
/*
$total = $wpdb->get_var("
SELECT COUNT(*)
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . $category_ids . ") AND wp_posts.post_type = 'product' " . $search_param);

$query = "
SELECT wp_posts.ID
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . $category_ids . ") AND wp_posts.post_type = 'product' " . $search_param;
*/

// Split & pick the first one
$first_product = explode(",", $category_ids);

$total = $wpdb->get_var("
SELECT COUNT(*)
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . @$first_product[0] . ") AND wp_posts.post_type = 'product' " . $search_param);

$query = "
SELECT wp_posts.ID
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . @$first_product[0] . ") AND wp_posts.post_type = 'product' " . $search_param;

$_SESSION['total']=$total;
$_SESSION['query']=$query;
$_SESSION['query_by_category']=false;

$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$result = $wpdb->get_results( $query . " ORDER BY ID DESC LIMIT ${offset}, ${items_per_page}" );


} else if(isset($_GET['product_cat']) && $_GET['product_cat'] != ""){

// searching by category

// $total = $wpdb->get_var("
// SELECT COUNT(*)
// FROM wp_posts p
// LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
// LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
// LEFT JOIN wp_terms t ON t.term_id = tax.term_id
// WHERE t.slug = '" . $_GET['product_cat'] . "' ");

// $query = "
// SELECT p.ID
// FROM wp_posts p
// LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
// LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
// LEFT JOIN wp_terms t ON t.term_id = tax.term_id
// WHERE t.slug = '" . $_GET['product_cat'] . "' ";

$total = $wpdb->get_var("
SELECT COUNT(*)
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . $product_cat_id . ") AND wp_posts.post_type = 'product' " . $search_param);

$query = "
SELECT wp_posts.ID
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (" . $product_cat_id . ") AND wp_posts.post_type = 'product' " . $search_param;

$_SESSION['total']=$total;
$_SESSION['query']=$query;
$_SESSION['query_by_category']=true;

$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$result = $wpdb->get_results( $query . " ORDER BY ID DESC LIMIT ${offset}, ${items_per_page}" );


}


// end of else
}


?>

<!-- search Param ends here -->


<header class="mobile-step-nav">
      <div class="container-fluid">
        <div class="row">
            <a href="<?php echo get_site_url(); ?>/step-two" class="btn secondry">prev</a>
            <h3 class="title"><span>1</span> Pick your drinks</h3>
            <a href="<?php echo get_site_url(); ?>/step-four" class="btn secondry">next</a>
        </div>
       </div>
    </header>



<section class="main-pro-container pro-list">
        <div class="container-fluid">

            <div class="row details-btn-cont">
               <div class="col-6"><a class="btn primary btn-block showRightPush">Drinks Category</a></div>
                <div class="col-6"><a href="#view-basket" class="btn secondry btn-block" data-toggle="modal" data-target="#view-basket">View Basket</a></div>
            </div>
            

            <div class="row step-cont text-center ">
            <div class="col-3 step prev">
                <h2 class="title step-count">1</h2>
                <p>Enter your Details</p>
            </div>
            
            <div class="col-3 step prev">
                <h2 class="title step-count">2</h2>
                <p>Get a Quote for Drinks</p>
            </div>
                
            <div class="col-3 step active">
                <h2 class="title step-count">3</h2>
                <p>Select Quantities of Drinks</p>
            </div>
             
                
            </div>
            
            <div class="row">
                <div class="col-xl-2 col-lg-3 link-cont">
                <div class="link">
                    <a href="<?php echo get_site_url(); ?>/step-two" class="back-btn">back</a>
                    <h4 class="title">Drinks Category</h4>
                    <ul>



<?php

// unique categories
$unique_categories = explode(',', $category_ids);

$args = array(
    'number'     => @$number,
    'orderby'    => @$orderby,
    'order'      => @$order,
    'hide_empty' => @$hide_empty,
    'include'    => @$ids
);

$product_categories = get_terms( 'product_cat', $args);
$ind = 0;

foreach( $product_categories as $cat ) { 

	if($cat->name != "other services" && in_array($cat->term_id, $unique_categories)){


        if($ind == 0){
            $first_product_name = ucwords(str_replace("-", " ", $cat->name));
            $ind++;
        }

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

        // if(isset($_SESSION['selected_bottles'])){
        //     for($i=0; $i<sizeof($_SESSION['selected_bottles']); $i++){
        //         $name = $_SESSION['selected_bottles'][$i][0];
        //         $calculated_bot = $_SESSION['selected_bottles'][$i][1];
        //         if($cat->slug == $name){
        //             $bottles = $calculated_bot;
        //         }
        //     }
        // }

        if(!isset($_GET['product_cat'])){
            if($cat->term_id == @$first_product[0]){
                $active = "active"; 

            }
        }

        $c_cat_slug = str_replace(" ", "-", $cat->name);
?>

                        <li class="<?php echo $active; ?> <?php echo $c_cat_slug; ?>-li">
                        <a href="<?php echo get_site_url(); ?>/step-three?product_cat=<?php echo $cat->slug; ?>"><i></i><?php echo ucwords($cat->name); ?>
                        <span class="count-down <?php if($bottles > 0){ echo "show-element"; } else { echo "hide-element"; } ?>"><?php echo $bottles; ?> BTL</span></a>
                        <input type="hidden" id="<?php echo $c_cat_slug; ?>-bottles" value="<?php echo $bottles; ?>" >
                        </li>
<?php } } ?>
                   
                    </ul> 
                </div>
                </div>
                
                <div class="col-xl-7 col-lg-9">
                <div class="pro-content">
                <div class="row">
                    <div class="col-lg-12 prod-title">
                    <h4 class="main-title pull-left title">
                    <?php
                    if(isset($_GET['product_cat']) && $_GET['product_cat'] != ""){
                    	$title = str_replace("-", " ", $_GET['product_cat']);
                    	echo ucwords($title);
                    } else if(isset($_GET['search'])){
                        echo ucwords($_POST['search_input']);

                    } else {
                        echo $first_product_name;
                    }
                    ?>
                    </h4>

                    <a class="btn secondry pull-right view-basket"  href="#view-basket" data-toggle="modal" data-target="#view-basket">
                    View Basket
                    </a>

                        <form class="pull-right" action="<?php echo get_site_url(); ?>/step-three?search=1" method="post">
                        <input type="text" class="fom-control" placeholder="Search Soft Drinks" name="search_input" id="search_input" />
                            <button class="btn secondry"></button>
                        </form>
                    





<!-- the numbers of product -->
<?php echo "<p class='pager-count'>" . sizeof($result) . " of " . $total ." products</p>"; ?>
<hr />
</div>



<!-- the loop for products without category -->
<?php 
	    	foreach($result as $res){
		    	$postid = $res->ID;
		        $product = get_post( $postid ); 
		        $price = get_post_meta( $postid, '_regular_price', true);
		        $slug = $product->post_name;
                $title = $product->post_title;

		        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($postid) );

                $term_list = wp_get_post_terms($postid,'product_cat',array('fields'=>'names'));
                $catname = $term_list[0];
                $catname = str_replace(" ", "-", $catname);

                $cat_id = wp_get_post_terms($postid,'product_cat',array('fields'=>'ids'));
                $cal_carton = get_term_meta($cat_id[0], 'wh_meta_carton', true);

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

                                // calculate carton
                                $btl = $_SESSION['product_basket']['product'][$i]['bottle']; if(!is_numeric($_SESSION['product_basket']['product'][$i]['bottle']) == true){ $btl = 0; }
                                $carton = $_SESSION['product_basket']['product'][$i]['carton']; if(!is_numeric($_SESSION['product_basket']['product'][$i]['carton']) == true){ $carton = 0; }
                                $cal_carton = @intval($btl / $carton);

                            }
                        }
                    }

                    $b_text = ($bottle_input > 1) ? "bottles" : "bottle";

?>

                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 prod-cont add<?php echo $postid; ?> remove<?php echo $postid; ?> add-prod<?php echo $postid; ?> substract<?php echo $postid; ?> add-input<?php echo $postid; ?>">
                    <div class="prod <?php echo $active; ?>">
                        <h5 class="title pro-name"><?php echo ucwords($title); ?></h5>
                        <h4 class="title pro-amount">₦ <?php echo str_replace(".00", "", number_format((float)$price,2,".",",")); ?></h4>
                        <img src="<?php echo $feat_image; ?>" class="pro-img" alt="" />

                        <span class="pro-cost <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>">
                        N <?php echo str_replace(".00", "", number_format((float)$item_total,2,".",",")); ?>
                        </span>
                        <br />
                        <input type="hidden" id="cost" value="<?php echo $price; ?>">

                        <span class="control">
                        <a href="" class="add-prod <?php if($active == "active"){ echo "hide-element"; } else { echo "show-element"; } ?>" id="add-prod<?php echo $postid; ?>" >add</a>
                        <a href="" class="add <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="add<?php echo $postid; ?>">+</a>
                        <input class="add-input  <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="add-input<?php echo $postid; ?>" type="text" value="<?php echo $bottle_input; ?>"/>
                        <a href="" class="substract <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="substract<?php echo $postid; ?>">-</a> 
                        <a href="" class="remove <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>" id="remove<?php echo $postid; ?>">x</a>
                        </span>
                        <span class="meta-data">
                        <!-- <p class="carton <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>"><span><?php echo $cal_carton; ?></span> Carton<?php if($cal_carton > 1) echo "s"; ?></p> -->
                        <p class="bottle <?php if($active == "active"){ echo "show-element"; } else { echo "hide-element"; } ?>"><span><?php echo $bottle_input; ?></span> <?php echo $b_text; ?></p>
                        <input type="hidden" id="bottle_input" value="<?php echo $bottle_input; ?>">
                        </span>

                        <input type="hidden" id="price" value="<?php echo $price; ?>">
                        <input type="hidden" id="category_name" value="<?php echo $catname; ?>">
                        <input type="hidden" id="product_name" value="<?php echo $title; ?>">
                        <input type="hidden" id="carton" value="<?php echo $cal_carton; ?>">
                    </div>
                    </div>
                    
<?php } /*}*/ ?>


<?php if(sizeof($result) == 0){ ?>
<h5 class="title pro-name">No Products Found</h5>
<?php } ?>

                    
                    <div class="col-lg-12 prod-title">
                    <hr />
                    </div>
                    <div class="col-lg-12 pager-cont">
                    

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

<?php

$data1 = "";

if($total != 0){      

$data1.=custom_paginate_links( array(
    'base' => add_query_arg( 'cpage', '%#%' ),
    'format' => '',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total' => ceil($total / ($items_per_page - $num_to_remove)),
    'current' => $page,
    'customq' => ''
));

}

echo $data1;
?>

  </ul>
</nav>

                        <a href="<?php echo get_site_url(); ?>/step-four" class="btn btn-next">Countinue to Place Order</a>
                        </div>
                        
 
                    
                    
                    
                 </div>   
                </div>
                </div>
                
                
                <div class="col-xl-3 col-lg-4 basket-cont">
                <div class="basket">
                
                    <div class="top-sec text-center">
                        <?php 
                        $budjet = 0;
                        $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
                        ?>
                        <p class="budget-label">Budget</p>
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



                    <input type="hidden" id="save_categories_data" value="<?php if(isset($_SESSION['save_categories_data'])){ echo $_SESSION['save_categories_data']; } ?>" >

                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>/step-three" >

                    <input type="hidden" id="total_incur_product" value="<?php echo $product_total; ?>" >

                    <!--div class="notice">1% will be charged by drink.ng for every trasaction that takes place on the site</div-->
                    <a href="<?php echo get_site_url(); ?>/step-four" class="btn btn-next btn-block">Next</a>
            </div>
            </div>
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
                    pay: "2"
                },
                success: function (data){
                    
                }
            });
</script>
<?php } ?>