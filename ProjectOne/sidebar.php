<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package ProjectOne
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) && !is_singular() ) : ?>
	<aside id="sidebar1"><!-- sidebar1 -->
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- end of sidebar1 -->
<?php endif; ?>
	
<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<aside id="sidebar2"><!-- sidebar2 -->
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</aside><!-- end of sidebar 2 -->
<?php endif; ?>