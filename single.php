<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<!--<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">-->
			<?php /* The loop */ ?>


		<section id="brand" class="press-release-main">
			<div class="row">
				<div class="container brand-container press">
					<ol class="breadcrumb">
                        <li><a href="/press">back to press</a></li>
                      <li class="active">press release</li>
                    </ol>
				</div>
			</div>
		</section>
        
        
			<?php while ( have_posts() ) : the_post(); ?>
            <?php $postid = get_the_ID(); ?>
 <section id="press-article-cont">
			<div class="row">
				<div class="container article-main-cont">
					<div class="col-xs-8"><h1 class="title text-left "><?php echo get_the_title( $postid ); ?></h1>
                        
                        <div class="article-img">
                        <?php 
						
						$feat_image = wp_get_attachment_url( get_post_thumbnail_id($postid) ); ?>
                            <img src="<?php echo $feat_image; ?>" class="img-responsive" alt="" />
                        </div>
                        <div id="date-posted">
                            <?php echo the_date('l, F j, Y', FALSE); ?>
                            Lagos, Nigeria.
                        </div> 
        
				<?php //get_template_part( 'content', get_post_format() ); ?>
                <?php echo the_content(); ?>
                
                
                
                <img src="" class="img-responsive" alt="" />
                        
                </div>
                
                
                
                
                
                <div id="press-side-bar" class="col-xs-4">
				<h2 class="title">related press articles</h2>
                    <ul>
                    
               <?php /* Get all post */

$args = array( 'posts_per_page' => 5 );
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); 
?>
                        <li>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p>
                                    <small>
                                        <?php echo get_the_date('l, F j, Y', FALSE); ?>
                                        Lagos, Nigeria.
                                    </small>
                                </p>
                        </li>
<?php endforeach; 
wp_reset_postdata(); ?>
                     </ul>
                        
                        
                    
    

                        <!--<div class="side-ad"><img src="http://localhost/irokong/wp-content/uploads/2015/05/Jason-Award.jpg" class="img-responsive" alt="" /></div>
                        <div class="side-ad"><img src="http://localhost/irokong/wp-content/uploads/2015/05/Jason-Award.jpg" class="img-responsive" alt="" /></div>-->
				</div>
                    
                    </div>
				
			
				
				
			</div>
            
            
		</section>
                    
                    
                
				<?php //twentythirteen_post_nav(); ?>
				<?php //comments_template(); ?>

			<?php endwhile; ?>

		<!--</div> #content -->
	<!--</div> #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>