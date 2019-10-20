<?php

if(isset($_POST['submit'])){

    $_SESSION['event_type'] = @$_POST['event_type'];
    $_SESSION['no_of_guest'] = str_replace(",", "", @$_POST['no_of_guest']);

    $_SESSION['budget'] = @$_POST['budget'];
    $_SESSION['state'] = @$_POST['state'];
    $_SESSION['state_name'] = @$_POST['state_name'];

    if(isset($_POST['locals'])){
        $_SESSION['locals'] = @$_POST['locals'];
    }

    if(isset($_POST['location_of_event'])){
        $_SESSION['location_of_event'] = @$_POST['location_of_event'];
    } else if(isset($_POST['location_of_event_text'])){
        $_SESSION['location_of_event'] = @$_POST['location_of_event_text'];
        $_SESSION['location_of_event_text'] = 1;
    }

    $_SESSION['event_date'] = @$_POST['event_date'];
    $_SESSION['email'] = @$_POST['email'];

    wp_safe_redirect(get_site_url() . "/step-two");
}

?>
<?php
/**
 * Template Name: Front

 */

$_SESSION['LAST_PAGE_VISITED'] = $pagename;

get_header(); ?>

<?php

// Get no of lowest product prices by category
set_minimum_prices();
set_party_calculations();

// echo $_SESSION["water-price"]; echo "<br><br>";
// echo $_SESSION["soft-drinks-price"]; echo "<br><br>";
// echo $_SESSION["vodka-price"]; echo "<br><br>";

?>



<?php


$json = file_get_contents('states.json', true);
$states_array = json_decode($json, TRUE);

?>

<header class="primary">
        
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="logo" />  
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
        <li class="nav-item"><a href="<?php echo wp_logout_url(  get_site_url() ); ?>" class="btn">Log Out</a></li>

      <?php } else { ?>
        <li class="nav-item"><a href="<?php echo get_site_url(); ?>/login" class="btn secondry">Login</a></li>
      <?php } ?>

    </ul>
      
  </div>
  </div>
</nav>
    </header>
    
    <section class="banner">
        <div class="container">
            <div class="row">
                 <div class="col-xl-8 col-lg-7 col-md-12 text-left pro-cont">
                    <h1 class="title">Order drinks for your event in just 5 Steps</h1>
                    <!-- <img src="<?php echo get_template_directory_uri(); ?>/images/bottles.png" alt="" class="img-fluid" /> -->
                </div>
                
                <div class="col-xl-4 col-lg-5 offset-lg-0 col-md-8 offset-md-2  offset-sm-0 tab-nav-cont text-center form-cont">
                    <form id="step-one" method="post" action="">

                        <label class="col-12">
                       <select class="form-control" name="state" id="state" required >
                       <?php
                                if(isset($_SESSION['state']) && isset($_SESSION['state_name'])){
                                    echo "<option value='". $_SESSION['state'] ."' selected>" . $_SESSION['state_name'] . "</option>";
                                }
                        ?>
    <?php
    $list_of_states = "";
    $list_of_states .= "<option value=''>Select State</option>";
    for($i=0; $i<37; $i++){
        $list_of_states .=  "<option value='" . $states_array[$i]['state']['id'] . "'>" . $states_array[$i]['state']['name'] . "</option>";
    }
    echo $list_of_states . "</select>";
    ?>
                        <input type="hidden" name="state_name" id="state_name" >
                       </label>


                        <label class="col-12">
                        <select class="form-control" name="locals" id="locals" required <?php if(!isset($_SESSION['locals'])){ echo "disabled='true'"; } ?> >
                        <?php
                                if(isset($_SESSION['locals'])){
                                    echo "<option value='". $_SESSION['locals'] ."' selected>" . $_SESSION['locals'] . "</option>";
                                }
                        ?>
                        <option value=''>Select Local Government</option>
                        </select>
                        </label>

                        <label class="col-12">
                        <select class="form-control" name="location_of_event" id="location_of_event" required <?php if(@$_SESSION['location_of_event'] == ""){ echo "disabled='true'"; } else { echo "required"; } ?>  >
                        <?php
                                if(isset($_SESSION['location_of_event']) && $_SESSION['location_of_event'] != ""){
                                    echo "<option value='". $_SESSION['location_of_event'] ."' selected>" . $_SESSION['location_of_event'] . "</option>";
                                }
                        ?>
                        <option value=''>Select Location of event</option>
                        </select>

                        <input type="text" name="location_of_event_text" id="location_of_event_text" class="form-control" placeholder="Location of event" value="<?php if(isset($_SESSION['location_of_event'])){ echo $_SESSION['location_of_event']; } ?>" />
                        
                        </label>

                        <label class="col-12">
                            <select class="form-control" name="event_type" id="event_type" required >
                            <?php
                                if(isset($_SESSION['event_type'])){
                                    echo "<option value='". $_SESSION['event_type'] ."' selected>" . $_SESSION['event_type'] . "</option>";
                                }
                            ?>
                            <option value=''>Event Type</option>
                            <option value='Wedding'>Wedding</option>
                            <option value='Engagement'>Engagement</option>
                            <option value='Corporate Event'>Corporate Event</option>
                            <option value='House Party'>House Party </option>
                            <option value='Beach Party'>Beach Party</option>
                            <option value='Childrens party'>Childrens party</option>
                            <option value='Funneral'>Funneral</option>
                            <option value='Naming Ceremony'>Naming Ceremony</option>
                            </select>
                        </label>
                       <label class="col-12"><input type="text" name="no_of_guest" id="no_of_guest" class="form-control allow_numbers_only" placeholder="Number of guests" required value="<?php if(isset($_SESSION['no_of_guest'])){ echo $_SESSION['no_of_guest']; } ?>" /></label>
                       <label class="col-12"><input type="text" name="budget" id="budget" class="form-control allow_numbers_only" placeholder="Budget" required value="<?php if(isset($_SESSION['budget'])){ echo $_SESSION['budget']; } ?>" /></label>

                       

                        

                        <label class="col-12"><input type="text"  name="event_date" id="event_date" class="form-control" placeholder="Event Date" required value="<?php if(isset($_SESSION['event_date'])){ echo $_SESSION['event_date']; } ?>" /></label>
                        <label class="col-12"><input type="email" name="email" id="email" class="form-control" placeholder="Email" required  value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>" /></label>
                        <div class="col-12"><button type="submit" name="submit" class="btn primary btn-block">Continue</button></div>
                    </form>
                </div>
                
            </div>    
            </div>
    </section>

    <section class="how-it-works">
        <div class="container">
            <div class="row">
                <h3 class="title main-title text-center col-12">How it works</h3>
            
                <!-- <div class="col-lg-3 text-center steps-cont step-1">
                    <span class="step-img"><img src="<?php echo get_template_directory_uri(); ?>/images/step-1.svg" alt="" class="img-fluid" /></span>
                    <span class="steps-bg"></span>
                    <h2 class="count title">1</h2>
                    <p>Enter your details</p>
                </div> -->

                <div class="col-lg-1">
                    
                </div> 

                
                <div class="col-lg-3 text-center steps-cont step-2">
                   <span class="step-img"><img src="<?php echo get_template_directory_uri(); ?>/images/step-2.svg" alt="" class="img-fluid" /></span>
                    <span class="steps-bg"></span>
                    <h2 class="count title">1</h2>
                    <p>Get a Quote for Drinks</p>
                </div>
                
                 <div class="col-lg-3 text-center steps-cont step-3">
                   <span class="step-img"><img src="<?php echo get_template_directory_uri(); ?>/images/step-5.svg" alt="" class="img-fluid" /></span>
                    <span class="steps-bg"></span>
                    <h2 class="count title">2</h2>
                    <p>Select Quantities of Drinks</p>
                </div>
                
                <div class="col-lg-3 text-center steps-cont step-4">
                   <span class="step-img"><img src="<?php echo get_template_directory_uri(); ?>/images/step-3.svg" alt="" class="img-fluid" /></span>
                    <span class="steps-bg"></span>
                    <h2 class="count title">3</h2>
                    <p> Place your order</p>
                </div>
                
                 <div class="col-lg-3 text-center steps-cont step-5">
                   <span class="step-img"><img src="<?php echo get_template_directory_uri(); ?>/images/step-4.svg" alt="" class="img-fluid" /></span>
                    <span class="steps-bg"></span>
                    <h2 class="count title">4</h2>
                    <p> Pay</p>
                </div>
                
                <div class="col-lg-12 text-center"><a href="<?php echo get_site_url() ?>/about" class="btn ">Learn More</a></div>
               
            </div>
        </div>
    </section>
    
    <section class="why-us">
    
        <div class="container">
        <div class="row">
          
            <h2 class="title text-center col-12 main-title">Why Choose Us?</h2>
            <h4 class="title text-center col-12">Trusted partner with the following companies </h4>
            
            <ul>
            <?php
            global $wpdb;
            $query = "Select * from wp_drinkbrands";
            $result = $wpdb->get_results($query);
                foreach($result as $res){ ?>
                    <li><a target="_blank" href="<?php echo $res->link; ?>"><img src="<?php echo $res->url; ?>" alt="" class="img-fluid" /></a></li>
            <?php
                }
            ?>
            </ul>
               
        </div>
        </div>
        
    </section>
    
    
    <section class="testimonies">
        <div class="container">
            <div class="row">
            <div class="col-12">
                    <h2 class="title text-center">See what our customers are saying about us</h2>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                <div class="testimony-carousel owl-theme">
    <div class="item">
        <div class="testi-main-cont">
        <div class="testi-cont">
        <p class="content">Great service, sold my car in less than 45 minutes and saved me weeks of haggling with other buyers!</p>
        </div>
            <p class="name">Bukky Olowude/ BB wedding</p>
        </div>
                
    </div>
    <div class="item">
        <div class="testi-main-cont">
        <div class="testi-cont">
        <p class="content">Great service, sold my car in less than 45 minutes and saved me weeks of haggling with other buyers!</p>
        </div>
            <p class="name">Bukky Olowude/ BB wedding</p>
        </div>
                
    </div>
    <div class="item">
        <div class="testi-main-cont">
        <div class="testi-cont">
        <p class="content">Great service, sold my car in less than 45 minutes and saved me weeks of haggling with other buyers!</p>
        </div>
            <p class="name">Bukky Olowude/ BB wedding</p>
        </div>
                
    </div>
    <div class="item">
        <div class="testi-main-cont">
        <div class="testi-cont">
        <p class="content">Great service, sold my car in less than 45 minutes and saved me weeks of haggling with other buyers!</p>
        </div>
            <p class="name">Bukky Olowude/ BB wedding</p>
        </div>
                
    </div>
    <div class="item">
        <div class="testi-main-cont">
        <div class="testi-cont">
        <p class="content">Great service, sold my car in less than 45 minutes and saved me weeks of haggling with other buyers!</p>
        </div>
            <p class="name">Bukky Olowude/ BB wedding</p>
        </div>
                
    </div>
                    
                    
                    
</div>
                </div>
            </div>
        </div>
    </section>
    
    
     <section class="cal-cap">
        <div class="container">
            <div class="row">
            <!-- <div class="col-lg-6 offset-lg-2 col-md-9 offset-md-0"> -->
            <div class="col-lg-8  col-md-12 offset-md-0">
                    <h2 class="title text-left">With drinks.ng the party never stops</h2>
                </div>
                <div class="col-lg-3 col-md-3">
                <img src="<?php echo get_template_directory_uri(); ?>/images/cal.svg" alt="" class="img-fluid" />
                </div>
                
            </div>
            
        </div>
    </section>

    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>" >




<?php  get_footer(); ?>