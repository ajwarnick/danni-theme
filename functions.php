<?php
/**
 * Functions and definitions
 *
 */

/*
 * Let WordPress manage the document title.
 */
add_theme_support( 'title-tag' );

/*
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
) );

/** 
 * Include primary navigation menu
 */
function untheme_nav_init() {
	register_nav_menus( array(
		'menu-1' => 'Primary Menu',
	) );
}
add_action( 'init', 'untheme_nav_init' );

/**
 * Register widget area.
 *
 */
function untheme_widgets_init() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar-1',
		'description'   => 'Add widgets',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'untheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function untheme_scripts() {
	wp_enqueue_style( 'untheme-style', get_stylesheet_uri() );
	wp_enqueue_style( 'untheme-custom-style', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_script( 'untheme-scripts', get_template_directory_uri() . '/assets/js/scripts.js' );
}
add_action( 'wp_enqueue_scripts', 'untheme_scripts' );

function untheme_create_post_custom_post() {
	register_post_type('custom_post', 
		array(
		'labels' => array(
			'name' => __('Custom Post', 'untheme'),
		),
		'public'       => true,
		'hierarchical' => true,
		'supports'     => array(
			'title',
			'editor',
			'excerpt',
			'custom-fields',
			'thumbnail',
		), 
		'taxonomies'   => array(
				'post_tag',
				'category',
		) 
	));
}
add_action('init', 'untheme_create_post_custom_post'); // Add our work type

//====================================================================
// Add New Color Option in Existing Colors Section in Customizer
//====================================================================
 


function danni_customizer_add_colorPicker( $wp_customize){
     
    class WP_Customize_Range_Control extends WP_Customize_Control
	{
		public $type = 'custom_range';
		public function enqueue()
		{
			wp_enqueue_script(
				'cs-range-control',
				'path/to/range-control.js',
				array('jquery'),
				false,
				true
			);
		}
		public function render_content()
		{
			?>
			<label>
				<?php if ( ! empty( $this->label )) : ?>
					<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<?php endif; ?>
				<div class="cs-range-value"><?php echo esc_attr($this->value()); ?></div>
				<input data-input-type="range" type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
				<?php if ( ! empty( $this->description )) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
 
     
    // Add Settings 
    $wp_customize->add_setting( 'danni_type_color', array(
        'default' => '#353535',
    ));
 
    $wp_customize->add_setting( 'danni_site_bgcolor', array(
        'default' => '#f7dcc5',                        
    ));

	$wp_customize->add_setting( 'danni_accent_color', array(
        'default' => '#4c45d3',
    ));

	$wp_customize->add_setting( 'menu_offset', array(
        'default' => 0,
    ));

	
 
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'danni_type_color', array(
        'label' => 'Type Color',
        'section' => 'colors',
        'settings' => 'danni_type_color'
 
    )));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'danni_site_bgcolor', array(
        'label' => 'Site Background',
        'section' => 'colors',
        'settings' => 'danni_site_bgcolor'
    )));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'danni_accent_color', array(
        'label' => 'Accent Color',
        'section' => 'colors',
        'settings' => 'danni_accent_color'
    )));

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'menu_offset',
			array(
				'label'       => 'Menu Offset',
				'section'     => 'title_tagline',
				'priority'    => 10, 
				'settings'    => 'menu_offset',
				'description' => 'Measurement is in percentage of viewport height.',
				'input_attrs' => array(
					'min' => 0,
					'max' => 80,
				),
			)
		)
	);
 
}
function danni_generate_theme_option_css(){
 
    $typeColor = get_theme_mod('danni_type_color');
    $backgroundColor = get_theme_mod('danni_site_bgcolor');
	$accentColor = get_theme_mod('danni_accent_color');
	$menuOffset = get_theme_mod('menu_offset');
    if(!empty($accentColor) || !empty($typeColor) || !empty($backgroundColor) ):
     
    ?>
	<!-- Hello World -->
    <style type="text/css" id="danni-theme-option-css">
		:root{
			--main-color: <?php echo $accentColor; ?>;
			--main-deep: <?php echo $typeColor; ?>;
			--main-background: <?php echo $backgroundColor; ?>;
			--sidebarTopOffset: <?php echo $menuOffset; ?>vh;
		}
    </style>    
    <?php
 
    endif;    
}
 

add_action( 'customize_register', 'danni_customizer_add_colorPicker' );
add_action( 'wp_head', 'danni_generate_theme_option_css' );