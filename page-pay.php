<?php
/**
 * Template Name: pay

 */

get_header(); ?>

<style>
iframe, html, body{
    overflow:0 !important;
}
</style>

<?php


$client_name = "";
$client_phone = "";
$delivery_address = "";

if(isset($_POST['pay'])){

  $client_name = $_POST['client_name'];
  $client_phone = $_POST['client_phone'];
  $delivery_address = $_POST['delivery_address'];


$amount = "0";  
if(isset($_POST['amount'])){
  $amount = $_POST['amount'] . "00";
}
$amount = (int)$amount;

?>

  <section class="main-pro-container">
        <div class="container">
            
            <div class="row">

              <div class="col-lg-4 offset-lg-4 loading-msg">
                  <p>Loading payment screen, please wait...</p>
              </div>
            
                <div class="col-lg-4 offset-lg-4 login-cont" style="height:auto !important">
                
<script src="https://js.paystack.co/v1/inline.js"></script>
<div id="paystackEmbedContainer"></div>

<script>
  PaystackPop.setup({
   key: 'pk_test_e3263039023f38cce66cf41dbd9f582e39a2f52c',
   email: '<?php echo @$_SESSION['email']; ?>',
   amount: <?php echo $amount; ?>,
   container: 'paystackEmbedContainer',
   callback: function(response){
        <?php unset_all_data(); ?>

          $.ajax({
                type: 'GET',
                url: "<?php echo get_site_url(); ?>/ajax-pay-order",
                contentType: "application/json; charset=utf-8",
                data:{
                    pay: "3"
                },
                success: function (data){ }
            });

        alert('Payment successful. transaction ref is ' + response.reference);
        window.location.href="<?php echo get_site_url(); ?>";
    },
  });
</script>


                </div>
            
            </div>
         
        </div>
    </section>

<?php

}

?>

<?php get_footer(); ?>


<script>
$( document ).ready(function() {
  $('iframe').prop('scrolling', 'no');
});

$(document).ready(function() { 
    $('iframe').load(function() { 
        $('.loading-msg').hide();
    });
});

</script>


<?php if(isset($_POST['pay'])){ ?>
<script>
          $.ajax({
                type: 'GET',
                url: "<?php echo get_site_url(); ?>/ajax-pay-order",
                contentType: "application/json; charset=utf-8",
                data:{
                    client_name: "<?php echo $client_name; ?>",
                    client_phone: "<?php echo $client_phone; ?>",
                    delivery_address: "<?php echo $delivery_address; ?>",
                    pay: "2"
                },
                success: function (data){
                    
                }
            });
</script>
<?php } ?>