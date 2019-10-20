<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_check'),
		'two' => __('Two', 'options_check'),
		'three' => __('Three', 'options_check'),
		'four' => __('Four', 'options_check'),
		'five' => __('Five', 'options_check')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_check'),
		'two' => __('Pancake', 'options_check'),
		'three' => __('Omelette', 'options_check'),
		'four' => __('Crepe', 'options_check'),
		'five' => __('Waffle', 'options_check')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/image/';

	$options = array();

	

	/*$options[] = array(
		'name' => __('Input Text Mini', 'options_check'),
		'desc' => __('A mini text input field.', 'options_check'),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text');*/
    $wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

//////////////////////////////////////////////HEADER SETTINGS START////////////////////////////////////////////////////////////////////
	$options[] = array(
		'name' => __('Header Settings', 'options_check'),
		'type' => 'heading');
		
	 $options[] = array(
		'name' => __('Upload Logo', 'options_check'),
		'desc' => __('Image Size should be 397x69 PX', 'options_check'),
		'id' => 'llogo_uploader',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Upload Favicon Image', 'options_check'),
		'desc' => __('Upload Your favicon.ico [16x16 PX]', 'options_check'),
		'id' => 'lfavicon_uploader',
		'type' => 'upload');
	/*$options[] = array(
		'name' => __('Header Telephone No', 'options_check'),
		'desc' => __('Enter Header Telephone', 'options_check'),
		'id' => 'header_tel',
		'std' => 'Tel: 123-343 3241',
		'type' => 'text');
	$options[] = array(
		'name' => __('Header E-mail', 'options_check'),
		'desc' => __('Enter Header E-mail', 'options_check'),
		'id' => 'headerad_email',
		'std' => 'e-Mail: info@leesgoo.com',
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter Link', 'options_check'),
		'desc' => __('Enter Your Twitter Page Link', 'options_check'),
		'id' => 'twitter_link1',
		'std' => 'http://twitter.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Facebook Link', 'options_check'),
		'desc' => __('Enter Your Facebook Page Link', 'options_check'),
		'id' => 'facebook_link1',
		'std' => 'http://www.facebook.com',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Vimeo Link', 'options_check'),
		'desc' => __('Enter Your Vimeo Page Link', 'options_check'),
		'id' => 'vimeo_link1',
		'std' => 'http://www.vimeo.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Youtube Link', 'options_check'),
		'desc' => __('Enter Your Youtube Link', 'options_check'),
		'id' => 'youtube_link1',
	    'std' => 'http://www.youtube.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Pin Link', 'options_check'),
		'desc' => __('Enter Your Pin Link', 'options_check'),
		'id' => 'pin_link1',
	    'std' => 'http://www.pin.com',
		'type' => 'text');*/
	/*$options[] = array(
		'name' => __('Header Like Box Facebook URL', 'options_check'),
		'desc' => __('Enter Facebook URL', 'options_check'),
		'id' => 'header_furl',
		'std' => 'https://www.facebook.com',
		'type' => 'text');
	$options[] = array(
		'name' => __('Header Like Box Twitter URL', 'options_check'),
		'desc' => __('Enter Twitter URL', 'options_check'),
		'id' => 'header_turl',
		'std' => 'https://twitter.com',
		'type' => 'text');*/
//////////////////////////////////////////////HEADER SETTINGS END////////////////////////////////////////////////////////////////////
	
//////////////////////////////////////////////SIDEBAR SETTINGS START////////////////////////////////////////////////////////////////////
	/*$options[] = array(
		'name' => __('Sidebar Settings', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Sidebar Ad 1', 'options_check'),
		'desc' => __('Upload Sidebar Ad 1 Image [301x94 PX]', 'options_check'),
		'id' => 'sidebarad1_uploader',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Sidebar Ad 1 URL', 'options_check'),
		'desc' => __('Enter Sidebar Ad 1 URL', 'options_check'),
		'id' => 'headerad1_link',
		'std' => 'http://discordmagazine.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Sidebar Ad 2', 'options_check'),
		'desc' => __('Upload Sidebar Ad 2 Image [301x94 PX]', 'options_check'),
		'id' => 'sidebarad2_uploader',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Sidebar Ad 2 URL', 'options_check'),
		'desc' => __('Enter Sidebar Ad 2 URL', 'options_check'),
		'id' => 'headerad2_link',
		'std' => 'http://discordmagazine.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Sidebar Ad 3', 'options_check'),
		'desc' => __('Upload Sidebar Ad 3 Image [301x94 PX]', 'options_check'),
		'id' => 'sidebarad3_uploader',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Sidebar Ad 3 URL', 'options_check'),
		'desc' => __('Enter Sidebar Ad 3 URL', 'options_check'),
		'id' => 'headerad3_link',
		'std' => 'http://discordmagazine.com',
		'type' => 'text');
		
	*/
	
//////////////////////////////////////////////SIDEBAR SETTINGS END////////////////////////////////////////////////////////////////////
	
//////////////////////////////////////////////FOOTER SETTINGS START////////////////////////////////////////////////////////////////////
	
	/*$options[] = array(
		'name' => __('Footer Settings', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Twitter Link', 'options_check'),
		'desc' => __('Enter Your Twitter Page Link', 'options_check'),
		'id' => 'twitter_link',
		'std' => 'https://twitter.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Facebook Link', 'options_check'),
		'desc' => __('Enter Your Facebook Page Link', 'options_check'),
		'id' => 'facebook_link',
		'std' => 'https://www.facebook.com',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus Link', 'options_check'),
		'desc' => __('Enter Your Google Plus Page Link', 'options_check'),
		'id' => 'gplus_link',
		'std' => 'http://www.plus.google.com',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('RSS Link', 'options_check'),
		'desc' => __('Enter Your RSS Link', 'options_check'),
		'id' => 'rss_link',
	    'std' => 'http://www.rss.com',
		'type' => 'text');
	$options[] = array(
		'name' => __('Footer Phone No:', 'options_check'),
		'desc' => __('Enter Footer Phone No .', 'options_check'),
		'id' => 'fphone_text',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Footer E-mail', 'options_check'),
		'desc' => __('Enter Footer E-mail', 'options_check'),
		'id' => 'femail_text',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Footer Copyright Text', 'options_check'),
		'desc' => __('Enter Footer Copyright Text .', 'options_check'),
		'id' => 'copyright_ftext',
		'std' => 'Copyright© 2013. Paleo. All Rights Reserved.',
		'type' => 'text');
	
//////////////////////////////////////////////FOOTER SETTINGS END////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////OTHER SETTINGS START////////////////////////////////////////////////////////////////////
    $options[] = array(
		'name' => __('Other Settings', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Sidebar Why Us?', 'options_check'),
		'desc' => sprintf( __( 'Enter Text Below:', 'options_check' ), '' ),
		'id' => 'whyus_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Hotspot1', 'options_check'),
		'desc' => __('Enter Hotspot1', 'options_check',''),
		'id' => 'hotspot1',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Hotspot2', 'options_check'),
		'desc' => __('Enter Hotspot2', 'options_check',''),
		'id' => 'hotspot2',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Hotspot3', 'options_check'),
		'desc' => __('Enter Hotspot3', 'options_check',''),
		'id' => 'hotspot3',
		'type' => 'editor',
		'settings' => $wp_editor_settings );*/
//////////////////////////////////////////////OTHER SETTINGS END////////////////////////////////////////////////////////////////////


	
	/*$options[] = array(
		'name' => __('Textarea', 'options_check'),
		'desc' => __('Textarea description.', 'options_check'),
		'id' => 'example_textarea',
		'std' => 'Default Text',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Input Select Small', 'options_check'),
		'desc' => __('Small Select Box.', 'options_check'),
		'id' => 'example_select',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $test_array);

	$options[] = array(
		'name' => __('Input Select Wide', 'options_check'),
		'desc' => __('A wider select box.', 'options_check'),
		'id' => 'example_select_wide',
		'std' => 'two',
		'type' => 'select',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Select a Category', 'options_check'),
		'desc' => __('Passed an array of categories with cat_ID and cat_name', 'options_check'),
		'id' => 'example_select_categories',
		'type' => 'select',
		'options' => $options_categories);

	$options[] = array(
		'name' => __('Select a Tag', 'options_check'),
		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);

	$options[] = array(
		'name' => __('Select a Page', 'options_check'),
		'desc' => __('Passed an pages with ID and post_title', 'options_check'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('Input Radio (one)', 'options_check'),
		'desc' => __('Radio select with default options "one".', 'options_check'),
		'id' => 'example_radio',
		'std' => 'one',
		'type' => 'radio',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Example Info', 'options_check'),
		'desc' => __('This is just some example information you can put in the panel.', 'options_check'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Input Checkbox', 'options_check'),
		'desc' => __('Example checkbox, defaults to true.', 'options_check'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');*/

	/*$options[] = array(
		'name' => __('Advanced Settings', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Check to Show a Hidden Text Input', 'options_check'),
		'desc' => __('Click here and see what happens.', 'options_check'),
		'id' => 'example_showhidden',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Hidden Text Input', 'options_check'),
		'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_check'),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Uploader Test', 'options_check'),
		'desc' => __('This creates a full size uploader that previews the image.', 'options_check'),
		'id' => 'example_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' => "Example Image Selector",
		'desc' => "Images for layout.",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' =>  __('Example Background', 'options_check'),
		'desc' => __('Change the background CSS.', 'options_check'),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('Multicheck', 'options_check'),
		'desc' => __('Multicheck description.', 'options_check'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('Colorpicker', 'options_check'),
		'desc' => __('No color selected by default.', 'options_check'),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );

	$options[] = array( 'name' => __('Typography', 'options_check'),
		'desc' => __('Example typography.', 'options_check'),
		'id' => "example_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );

	$options[] = array(
		'name' => __('Custom Typography', 'options_check'),
		'desc' => __('Custom typography options.', 'options_check'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );*/

	/*$options[] = array(
		'name' => __('Text Editor', 'options_check'),
		'type' => 'heading' );*/

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	/*$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Default Text Editor', 'options_check'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings ); */
		
		//////////////////////////////////////////////PAYMENT START////////////////////////////////////////////////////////////////////
   /* $options[] = array(
		'name' => __('Payment Settings', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Master Card:', 'options_check'),
		'desc' => __('Enter Master Card Link .', 'options_check'),
		'id' => 'mastercard',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('VISA Card:', 'options_check'),
		'desc' => __('Enter VISA Link .', 'options_check'),
		'id' => 'visacard',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Visa Electron:', 'options_check'),
		'desc' => __('Enter Visa Electron Link .', 'options_check'),
		'id' => 'visaelectron',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Discover:', 'options_check'),
		'desc' => __('Enter Discover Link .', 'options_check'),
		'id' => 'discover',
		'std' => '',
		'type' => 'text');
		
		
	$options[] = array(
		'name' => __('Maestro:', 'options_check'),
		'desc' => __('Enter Maestro Link .', 'options_check'),
		'id' => 'maestro',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Paypal:', 'options_check'),
		'desc' => __('Enter Paypal Link .', 'options_check'),
		'id' => 'paypal',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Amazan:', 'options_check'),
		'desc' => __('Enter Amazan Link .', 'options_check'),
		'id' => 'amazan',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('2checkout:', 'options_check'),
		'desc' => __('Enter 2checkout Link .', 'options_check'),
		'id' => '2checkout',
		'std' => '',
		'type' => 'text');
		*/
//////////////////////////////////////////////PAYMENT END////////////////////////////////////////////////////////////////////


	return $options;
}
?>