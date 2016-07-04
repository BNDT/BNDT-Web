<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library FreeStore
 */

function customizer_library_freestore_options() {

	// Theme defaults
	$blocks_bg_color = '#F7F7F7';
    
    $header_bg_color = '#FFFFFF';
    $footer_bg_color = '#F7F7F7';
    
    $header_font_color = '#2F2F2F';
    $footer_font_color = '#000000';
	
	$primary_color = '#29a6e5';
	$secondary_color = '#2886e5';
	
	$body_font_color = '#000000';
	$heading_font_color = '#000000';

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;
    
	
	// Site Layout Options
	$section = 'freestore-site-layout-section';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Layout Options', 'freestore' ),
		'priority' => '30',
		'description' => __( '', 'freestore' )
	);
	
    $choices = array(
        'freestore-site-boxed' => 'Boxed Layout',
        'freestore-site-full-width' => 'Full Width Layout'
    );
    $options['freestore-site-layout'] = array(
        'id' => 'freestore-site-layout',
        'label'   => __( 'Site Layout', 'freestore' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'freestore-site-full-width',
        'description' => __( '', 'freestore' )
    );
	$choices = array(
		'freestore-page-styling-flat' => 'Flat / One Color Style',
		'freestore-page-styling-raised' => 'Blocks / Raised Style'
	);
	$options['freestore-page-styling'] = array(
		'id' => 'freestore-page-styling',
		'label'   => __( 'Page Styling', 'freestore' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'freestore-page-styling-flat',
		'description' => __( '', 'freestore' )
	);
	$options['freestore-page-styling-color'] = array(
		'id' => 'freestore-page-styling-color',
		'label'   => __( 'Blocks Background Color', 'freestore' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $blocks_bg_color,
	);
	
	// WooCommerce style Layout
    if ( freestore_is_woocommerce_activated() ) :
    	
        $options['freestore-woocommerce-shop-fullwidth'] = array(
			'id' => 'freestore-woocommerce-shop-fullwidth',
			'label'   => __( 'Make Shop page full width', 'freestore' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);
        
        $choices = array(
            'freestore-woocommerce-layout-standard' => 'Standard Layout',
            'freestore-woocommerce-layout-centered' => 'Big Blocks Layout'
        );
        $options['freestore-woocommerce-layout'] = array(
            'id' => 'freestore-woocommerce-layout',
            'label'   => __( 'WooCommerce Layout', 'freestore' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'freestore-woocommerce-layout-standard',
            'description' => __( '', 'freestore' )
        );
        
    endif;
	
	
	// Header Layout Options
	$section = 'freestore-header-section';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Header Options', 'freestore' ),
		'priority' => '30',
		'description' => __( '', 'freestore' )
	);
	
	$options['freestore-header-remove-topbar'] = array(
		'id' => 'freestore-header-remove-topbar',
		'label'   => __( 'Remove the Top Bar', 'freestore' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);
	
	$options['freestore-header-menu-text'] = array(
		'id' => 'freestore-header-menu-text',
		'label'   => __( 'Menu Button Text', 'freestore' ),
		'section' => $section,
		'type'    => 'text',
		'default' => 'menu',
		'description' => __( 'This is the text for the mobile menu button', 'freestore' )
	);
	
	$options['freestore-header-search'] = array(
        'id' => 'freestore-header-search',
        'label'   => __( 'Hide Search', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to hide the site search', 'freestore' ),
        'default' => 0,
    );
    $options['freestore-header-hide-social'] = array(
        'id' => 'freestore-header-hide-social',
        'label'   => __( 'Hide Social Links', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Hide the social links in the header', 'freestore' ),
        'default' => 0,
    );
    
    
    // Slider Settings
    $section = 'freestore-slider-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Slider Options', 'freestore' ),
        'priority' => '35'
    );
    
    $choices = array(
        'freestore-slider-default' => 'Default Slider',
        'freestore-meta-slider' => 'Meta Slider',
        'freestore-no-slider' => 'None'
    );
    $options['freestore-slider-type'] = array(
        'id' => 'freestore-slider-type',
        'label'   => __( 'Choose a Slider', 'freestore' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'freestore-no-slider'
    );
    $options['freestore-slider-cats'] = array(
        'id' => 'freestore-slider-cats',
        'label'   => __( 'Slider Categories', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you want to display in the slider. Eg: "13,17,19" (no spaces and only comma\'s)', 'freestore' )
    );
    $options['freestore-meta-slider-shortcode'] = array(
        'id' => 'freestore-meta-slider-shortcode',
        'label'   => __( 'Slider Shortcode', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the shortcode give by meta slider.', 'freestore' )
    );
    $choices = array(
        'freestore-slider-size-small' => 'Small Slider',
        'freestore-slider-size-medium' => 'Medium Slider',
        'freestore-slider-size-large' => 'Large Slider'
    );
    $options['freestore-slider-size'] = array(
        'id' => 'freestore-slider-size',
        'label'   => __( 'Slider Size', 'freestore' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'freestore-slider-size-medium'
    );
    $options['freestore-slider-linkto-post'] = array(
        'id' => 'freestore-slider-linkto-post',
        'label'   => __( 'Link Slide to post', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to make the slide link to the post', 'freestore' ),
        'default' => 0,
    );
    $options['freestore-slider-remove-title'] = array(
        'id' => 'freestore-slider-remove-title',
        'label'   => __( 'Remove Slider Title', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to remove the text on the slide', 'freestore' ),
        'default' => 0,
    );
	$options['freestore-slider-auto-scroll'] = array(
        'id' => 'freestore-slider-auto-scroll',
        'label'   => __( 'Stop Auto Scroll', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Click to stop the slider scroll automatically', 'freestore' ),
        'default' => 0,
    );


	// Colors
	$section = 'colors';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Colors', 'freestore' ),
		'priority' => '80'
	);

	$options['freestore-header-bg-color'] = array(
		'id' => 'freestore-header-bg-color',
		'label'   => __( 'Header Background Color', 'freestore' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $header_bg_color,
	);
    $options['freestore-header-font-color'] = array(
        'id' => 'freestore-header-font-color',
        'label'   => __( 'Header Font Color', 'freestore' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    
    $options['freestore-primary-color'] = array(
        'id' => 'freestore-primary-color',
        'label'   => __( 'Primary Color', 'freestore' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $primary_color,
    );

	$options['freestore-secondary-color'] = array(
		'id' => 'freestore-secondary-color',
		'label'   => __( 'Secondary Color', 'freestore' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondary_color,
	);
    
    $options['freestore-footer-bg-color'] = array(
        'id' => 'freestore-footer-bg-color',
        'label'   => __( 'Footer Background Color', 'freestore' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $footer_bg_color,
    );
    $options['freestore-footer-font-color'] = array(
        'id' => 'freestore-footer-font-color',
        'label'   => __( 'Footer Font Color', 'freestore' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $footer_font_color,
    );
    

	// Font Options
	$section = 'freestore-typography-section';
	$font_choices = customizer_library_get_font_choices();

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Font Options', 'freestore' ),
		'priority' => '80'
	);

	$options['freestore-body-font'] = array(
		'id' => 'freestore-body-font',
		'label'   => __( 'Body Font', 'freestore' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Open Sans'
	);
	$options['freestore-body-font-color'] = array(
		'id' => 'freestore-body-font-color',
		'label'   => __( 'Body Font Color', 'freestore' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $body_font_color,
	);

	$options['freestore-heading-font'] = array(
		'id' => 'freestore-heading-font',
		'label'   => __( 'Heading Font', 'freestore' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Lato'
	);
	$options['freestore-heading-font-color'] = array(
		'id' => 'freestore-heading-font-color',
		'label'   => __( 'Heading Font Color', 'freestore' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $heading_font_color,
	);
	
	
	// Blog Settings
    $section = 'freestore-blog-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog Options', 'freestore' ),
        'priority' => '50'
    );
    
    $choices = array(
        'blog-post-standard-layout' => 'Standard Layout',
        'blog-post-top-layout' => 'Top Layout'
    );
    $options['freestore-blog-layout'] = array(
        'id' => 'freestore-blog-layout',
        'label'   => __( 'Blog Posts Layout', 'freestore' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-post-standard-layout'
    );
    $options['freestore-blog-full-width'] = array(
        'id' => 'freestore-blog-full-width',
        'label'   => __( 'Make Blog Full Width', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Click to make the blog page Full Width', 'freestore' ),
        'default' => 0,
    );
    $options['freestore-blog-title'] = array(
        'id' => 'freestore-blog-title',
        'label'   => __( 'Blog Page Title', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'default' => 'Blog'
    );
    $options['freestore-blog-cats'] = array(
        'id' => 'freestore-blog-cats',
        'label'   => __( 'Exclude Blog Categories', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you\'d like to EXCLUDE from the Blog, enter only the ID\'s with a minus sign (-) before them, separated by a comma (,)<br />Eg: "-13, -17, -19"<br />If you enter the ID\'s without the minus then it\'ll show ONLY posts in those categories.', 'freestore' )
    );
	
	
	// Footer Settings
    $section = 'freestore-footer-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Footer Layout Options', 'freestore' ),
        'priority' => '85'
    );
    
    $choices = array(
        'freestore-footer-layout-standard' => 'Standard Layout',
        'freestore-footer-layout-centered' => 'Centered Layout',
        'freestore-footer-layout-social' => 'Social Layout',
        'freestore-footer-layout-none' => 'None'
    );
    $options['freestore-footer-layout'] = array(
        'id' => 'freestore-footer-layout',
        'label'   => __( 'Footer Layout', 'freestore' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'freestore-footer-layout-social'
    );
    
    $options['freestore-footer-bottombar'] = array(
        'id' => 'freestore-footer-bottombar',
        'label'   => __( 'Remove the Bottom Bar', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Click this to hide the bottom bar of the footer', 'freestore' ),
        'default' => 0,
    );
    $options['freestore-footer-hide-social'] = array(
        'id' => 'freestore-footer-hide-social',
        'label'   => __( 'Hide Social Links', 'freestore' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Hide the social links in the footer', 'freestore' ),
        'default' => 0,
    );
	
	
	// Site Text Settings
    $section = 'freestore-website-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Website Text', 'freestore' ),
        'priority' => '50'
    );
    
    $options['freestore-website-site-add'] = array(
        'id' => 'freestore-website-site-add',
        'label'   => __( 'Header Address', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Cape Town, South Africa', 'freestore' ),
        'description' => __( 'This is the address in the header top bar and the social footer', 'freestore' )
    );
    $options['freestore-website-head-no'] = array(
        'id' => 'freestore-website-head-no',
        'label'   => __( 'Header Phone Number', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Call Us: +2782 444 YEAH', 'freestore' ),
        'description' => __( 'This is the phone number in the header top bar', 'freestore' )
    );
    
    $options['freestore-website-txt-copy'] = array(
        'id' => 'freestore-website-txt-copy',
        'label'   => __( 'Site Copy Text', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'freestore theme, by Kaira', 'freestore'),
        'description' => __( 'Enter the text in the bottom bar of the footer', 'freestore' )
    );
    $options['freestore-website-error-head'] = array(
        'id' => 'freestore-website-error-head',
        'label'   => __( '404 Error Page Heading', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Oops! <span>404</span>', 'freestore'),
        'description' => __( 'Enter the heading for the 404 Error page', 'freestore' )
    );
    $options['freestore-website-error-msg'] = array(
        'id' => 'freestore-website-error-msg',
        'label'   => __( 'Error 404 Message', 'freestore' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'It looks like that page does not exist. <br />Return home or try a search', 'freestore'),
        'description' => __( 'Enter the default text on the 404 error page (Page not found)', 'freestore' )
    );
    $options['freestore-website-nosearch-msg'] = array(
        'id' => 'freestore-website-nosearch-msg',
        'label'   => __( 'No Search Results', 'freestore' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'freestore'),
        'description' => __( 'Enter the default text for when no search results are found', 'freestore' )
    );
	
	
	// Social Settings
    $section = 'freestore-social-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Social Links', 'freestore' ),
        'priority' => '80'
    );
    
    $options['freestore-social-email'] = array(
        'id' => 'freestore-social-email',
        'label'   => __( 'Email Address', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-skype'] = array(
        'id' => 'freestore-social-skype',
        'label'   => __( 'Skype Name', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-facebook'] = array(
        'id' => 'freestore-social-facebook',
        'label'   => __( 'Facebook', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-twitter'] = array(
        'id' => 'freestore-social-twitter',
        'label'   => __( 'Twitter', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-google-plus'] = array(
        'id' => 'freestore-social-google-plus',
        'label'   => __( 'Google Plus', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-youtube'] = array(
        'id' => 'freestore-social-youtube',
        'label'   => __( 'YouTube', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-instagram'] = array(
        'id' => 'freestore-social-instagram',
        'label'   => __( 'Instagram', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-pinterest'] = array(
        'id' => 'freestore-social-pinterest',
        'label'   => __( 'Pinterest', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-linkedin'] = array(
        'id' => 'freestore-social-linkedin',
        'label'   => __( 'LinkedIn', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-tumblr'] = array(
        'id' => 'freestore-social-tumblr',
        'label'   => __( 'Tumblr', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['freestore-social-flickr'] = array(
        'id' => 'freestore-social-flickr',
        'label'   => __( 'Flickr', 'freestore' ),
        'section' => $section,
        'type'    => 'text',
    );
    

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'customizer_library_freestore_options' );
