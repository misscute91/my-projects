<?php
/**
 * Template Name: Contact

 */

get_header(); ?>

<section class="banner static">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center pro-cont">
                    <h1 class="title"> Any Question?</h1>
                    <p>We are transforming the way used cars are traded</p>
                </div>
            </div>    
            </div>
    </section>
    
    
    <section class="contact">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-4 offset-lg-4 text-center steps-cont">
                    <h2 class="title">Contact</h2>
                    <h4 class="title">info@drinks.ng</h4>
                    <form id="contact-form" class="row text-left" action="" method="post">
                        <label class="col-12">Name
                    <input type="text" class="form-control" name="name" id="name" required /></label>
                        
                        <label class="col-12">Email
                    <input type="email" class="form-control"  name="email" id="email" required /></label>
                        
                        <label class="col-12">phone
                    <input type="text" class="form-control" name="phone" id="phone" required /></label>
                        
                        <label class="col-12">Message
                            <textarea class="form-control" name="message" id="message" required ></textarea></label>
                        
                        <div class="col-12">
                        <button type="submit" name="submit" class="btn secondry btn-block">send</button>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </section>
    
   
        
     <section class="cal-cap">
        <div class="container">
            <div class="row">
            <div class="col-lg-8 col-md-9 offset-md-0">
                    <h2 class="title text-left">With drinks.ng the party never stops</h2>
                </div>
                <div class="col-lg-3 col-md-3">
                <img src="<?php echo get_template_directory_uri(); ?>/images/cal.svg" alt="" class="img-fluid" />
                </div>
                
            </div>
            
        </div>
    </section>

    <?php  get_footer(); ?>

<?php

if(isset($_POST['submit'])){
        $name = "" . $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $from_name = "Drinks.ng";
        $from_mail = "info@drinks.ng";

        $body = "";
        $body .= "Name: " . ucfirst($name) . "<br><br>";
        $body .= "Phone: " . ucfirst($phone). "<br><br>";
        $body .= "Email: " . ucfirst($email). "<br><br>";
        $body .= "Form Message: " . ucfirst($message);

        $headers = "From: ".$from_name." <".$from_mail.">\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";

        $to = "info@drinks.ng";
        $subject = 'A new message from Drinks Calculator Contact Form: ' . ucfirst($name);

        if(wp_mail( $to, $subject, $body, $headers )){
            echo "<script> alert('Mail sent, we would get back to you soon!'); </script>";
        }
}

?>

    