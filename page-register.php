<?php
/**
 * Template Name: Register

 */

get_header(); ?>

<?php

$json = file_get_contents('states.json', true);
$states_array = json_decode($json, TRUE);

?>


<section class="main-pro-container">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-12"><h3 class="title">Create Account</h3>
                <p>We will provide you with a more accurate price after your vehicle inspection at any of our Inspection Centers.</p>

                <?php

                      if(isset($_SESSION['agent_error_msg'])){
                        echo "<p class='reg-error'>ERROR: " . $_SESSION['agent_error_msg'] . "</p>";
                      }

                      ?>
                </div>
              <form action="<?php echo get_site_url(); ?>/registersuccess" id="agent_form" class="col-lg-10 creatacc" method="post" enctype="multipart/form-data" >
                   <div class="row">

                       <div class="col-lg-3 col-md-4 offset-md-0 col-sm-6 offset-sm-3">
                    <label class="upload-cont" for="upload">
                        
                        <img src="<?php echo get_template_directory_uri(); ?>/images/upload-img.svg" alt="" class="img-fluid" />
                        <!-- <input type="file" id="upload" name="upload" required /> -->
                    <span class="btn primary btn-block">Upload Image</span>
                    </label>

                        </div>
                       <div class="col-lg-9 col-md-8 form-cont">
                       <div class="row">

                       	   <label class="col-lg-12">Your logo<input type="file" id="upload" name="upload" required class="form-control" style="padding: 0;" /></label>
                       	   <label class="col-lg-6">Email<input type="email" name="email" id="email" class="form-control" required value="<?php if(isset($_SESSION['agent_email'])){ echo $_SESSION['agent_email']; } ?>" /></label>
                           <label class="col-lg-6">Password<input type="password" name="password" id="password" class="form-control" required  /></label>
                           <label class="col-lg-6">Confirm password<input type="password" name="confirm_password" id="confirm_password" class="form-control" required /></label>
                           
                           

                           <label class="col-lg-6">First Name<input type="text" name="first_name" id="first_name" class="form-control" required value="<?php if(isset($_SESSION['agent_first_name'])){ echo $_SESSION['agent_first_name']; } ?>" /></label>
                           <label class="col-lg-6">Last Name<input type="text" name="last_name" id="last_name" class="form-control" required value="<?php if(isset($_SESSION['agent_last_name'])){ echo $_SESSION['agent_last_name']; } ?>" /></label>

                           

                           <label class="col-lg-6">Phone<input type="text" name="phone" id="phone" class="form-control" required value="<?php if(isset($_SESSION['agent_phone'])){ echo $_SESSION['agent_phone']; } ?>" /></label>
                           
                           <label class="col-lg-6">Company Name<input type="text" name="company_name" id="company_name" class="form-control" required value="<?php if(isset($_SESSION['agent_company_name'])){ echo $_SESSION['agent_company_name']; } ?>" /></label>
                           <label class="col-lg-6">Choose company color <br><input type="text" name="company_color" id="company_color" class="form-control" required /></label>


                           <label class="col-lg-6">State
                           <select class="form-control" name="agent_state" id="agent_state" required >
                       <?php
                                if(isset($_SESSION['agent_state']) && isset($_SESSION['agent_state_name'])){
                                    echo "<option value='". $_SESSION['agent_state'] ."' selected>" . $_SESSION['agent_state_name'] . "</option>";
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
                        <input type="hidden" name="agent_state_name" id="agent_state_name" >
                       </label>


                       <label class="col-lg-6">Local Government
                        <select class="form-control" name="agent_locals" id="agent_locals" <?php if(!isset($_SESSION['agent_locals'])){ echo "disabled='true'"; } ?> >
                        <?php
                                if(isset($_SESSION['locals'])){
                                    echo "<option value='". $_SESSION['agent_locals'] ."' selected>" . $_SESSION['agent_locals'] . "</option>";
                                }
                        ?>
                        <option value=''>Select Local Government</option>
                        </select>
                        </label>


                           <label class="col-lg-12">Address<textarea name="address" id="address" class="form-control" required ><?php if(isset($_SESSION['agent_address'])){ echo $_SESSION['agent_address']; } ?></textarea></label>
                           <label class="col-lg-12">About you<textarea class="form-control" name="about_you"  id="about_you" required ><?php if(isset($_SESSION['agent_about_you'])){ echo $_SESSION['agent_about_you']; } ?></textarea></label>

                           <!-- <label class="col-lg-12">Company Color<input type="text" name="company_color" id="company_color" class="color-field" required value="<?php if(isset($_SESSION['agent_company_color'])){ echo $_SESSION['agent_company_color']; } ?>" /></label>
 -->

                           <span class="col-12"><button type="submit" name="submit" class="btn secondry btn-block">Create Account</button></span>
                       </div>
                       </div>
                    </div>
                    <input type="hidden" id="website" value="<?php echo get_site_url(); ?>" />
                </form>
            
            </div>
         
        </div>
    </section>



<?php  get_footer(); ?>
