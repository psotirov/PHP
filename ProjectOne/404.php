<?php 
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package ProjectOne
 */

get_header(); ?>
<section id="main"><!-- #main content and sidebar area -->
	<section id="content"><!-- #content -->
		<article class="post error404 not-found">
			<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'ProjectOne' ); ?></h2>
			<div>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps one of the links below can help.', 'ProjectOne' ); ?></p>
				<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => '404' ) ); ?>
			</div>
		</article>
	</section><!-- end of #content -->
	<!-- !!!!!!sidebars go there!!!!!!! -->
	<?php get_sidebar (); ?>		
</section><!-- end of #main content and sidebar-->
<?php get_footer(); ?>     