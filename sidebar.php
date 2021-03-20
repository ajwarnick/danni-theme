<?php
/**
 * The sidebar containing the main widget area
 *
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div>
	<div class="site-sidebar">
		<h1 class="site-title menu_toggle"><?php bloginfo( 'name' ); ?></h1>
		<div class="mobile-menu">
			<nav class="main-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>
			</nav>
			<aside class="widget-area">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside>
		</div>
		
	</div>
</div>
