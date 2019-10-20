<?php
/**
 * Template Name: Login

 */

if(is_user_logged_in()){ 

    $prev_url = isset($_SESSION['LAST_PAGE_VISITED']) ? $_SESSION['LAST_PAGE_VISITED'] : '';
    if($prev_url != ""){
        wp_safe_redirect( get_site_url() . "/" . $prev_url);
    } else {
        wp_safe_redirect( get_site_url());
    }
    exit();
}





get_header(); ?>


<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<?php endif; ?>



<section class="main-pro-container">
        <div class="container">
            
            <div class="row">
            
                <div class="col-lg-4 offset-lg-4 login-cont">
                <form class="row" action="" method="post">
                    <h2 class="title col-lg-12">Login</h2>

                <label class="col-xs-12">
                    <?php wc_print_notices(); ?>
                </label>

            <?php do_action( 'woocommerce_login_form_start' ); ?>


                    <label class="col-lg-12">Username
                    <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                    </label>

                    <label class="col-lg-12">Password
                    <input type="password" name="password" id="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" />
                    </label>

                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                	<input type="submit" class="btn secondry btn-block" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />

                    <?php do_action( 'woocommerce_login_form' ); ?>

            <label class="col-lg-12 lost_your_passowrd">
                <a  href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
            </label>

            <?php do_action( 'woocommerce_login_form_end' ); ?>


                    </form>
                </div>
            
            </div>
         
        </div>
    </section>




<?php  get_footer(); ?>