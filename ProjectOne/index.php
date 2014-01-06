<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ProjectOne
 */

get_header(); ?>
<section id="main"><!-- #main content and sidebar area -->
	<section id="content"><!-- #content -->
        <?php 
        	if ( have_posts() ):
        		while ( have_posts() ):
        			the_post();
        ?>
		<article>
			<h2><?php the_title(); ?></h2>
			<div>
				<?php if ( is_singular() ):
							the_content();
							if ( is_single() ) :
								comments_template(); 
							endif;
					else : the_excerpt(); 
					endif; ?>				
			</div>
		</article>
		<?php endwhile; ?>
		<div style="text-align:center;">
		<?php posts_nav_link(' &#183; ', 'previous page', 'next page'); ?>
		</div>
		<?php endif; ?>
	</section><!-- end of #content -->
	<!-- !!!!!!sidebars go there!!!!!!! -->
	<?php get_sidebar (); ?>		
</section><!-- end of #main content and sidebar-->
<?php get_footer(); ?>     