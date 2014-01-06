<?php
/**
 * ProjectOne functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package ProjectOne
 */
 
/**
 * Registers our main widget areas.
 */
function projectone_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Links Sidebar' ),
		'id' => 'sidebar-1',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
        'after_title'   => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Stuff sidebar' ),
		'id' => 'sidebar-2',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
        'after_title'   => '</h3>'
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer sidebar' ),
		'id' => 'footer-sidebar',
		'before_widget' => '<aside class="footer-segment">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
        'after_title'   => '</h4>'
	) );
}
add_action( 'widgets_init', 'projectone_widgets_init' );

/**
 * Creates custom Read More link for excerpts.
 */
function new_excerpt_more( $more ) {
	return ' ... [ <a class="read-more" href="'. get_permalink( get_the_ID() ) .'">Read Full Article</a> ]';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );