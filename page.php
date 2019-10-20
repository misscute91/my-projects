<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
 <?php while ( have_posts() ) : the_post(); ?>

<section class="extra_meta uploadphoto">
<div class="container">
        <div class="row">

   <div class="add-extra-user-details col-xs-12">     
      <div class="upload-cont-container">

      <?php the_content(); ?>

                 </div>
</div> <!-- end div -->

</div>
</div>
</section>

<!-- <footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
</footer> --><!-- .entry-meta -->
                    
<?php endwhile; ?>

<?php  get_footer(); ?>