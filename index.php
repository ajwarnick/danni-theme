<?php
/**
 * The main template file
 */

get_header();
get_sidebar();
?>

<main id="main" class="site-main" role="main">

<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/grouping', get_post_type() );

	endwhile;

	the_posts_pagination( array(
		'prev_text' => __( 'Previous page' ),
		'next_text' => __( 'Next page' ),
	) );

endif;
?>

</main>

<?php
get_footer();