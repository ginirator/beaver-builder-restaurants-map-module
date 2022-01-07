<?php
/**
 * This is a restaurants map module
 *
 * @class FLRestaurantsMapModule
 */
class FLRestaurantsMapModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Restaurants Map', 'fl-builder'),
            'description'   => __('Restaurants Map.', 'fl-builder'),
            'category'		=> __('Media', 'fl-builder'),
            'dir'           => FL_MODULE_RESTAURANTS_MAP_DIR . 'modules/restaurants-map/',
            'url'           => FL_MODULE_RESTAURANTS_MAP_URL . 'modules/restaurants-map/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));

        // Register and enqueue the Frontend CSS File
        $this->add_css('frontend-style', $this->url . 'css/frontend.css');
    }

	/**
	 * Function that enqueue's scripts
	 */
	public function enqueue_scripts() {
		$this->add_js('frontend-script', $this->url . 'js/restaurants-map-lib.js', array(), rand(1,100000000), true);
		wp_localize_script( 'frontend-script', 'localized_number_of_map_markers_field', $this->settings->number_of_map_markers_field );
	}

	/**
	 * Ensure backwards compatibility with old settings.
	 *
	 * @since 2.2
	 * @param object $settings A module settings object.
	 * @param object $helper A settings compatibility helper.
	 * @return object
	 */
	public function filter_settings( $settings, $helper ) {

		// Make sure we have a typography array.
		if ( ! isset( $settings->typography ) || ! is_array( $settings->typography ) ) {
			$settings->typography            = array();
			$settings->typography_medium     = array();
			$settings->typography_responsive = array();
		}

		// Handle old font settings.
		if ( isset( $settings->font ) && is_array( $settings->font ) && isset( $settings->font['family'] ) && isset( $settings->font['weight'] ) ) {
			$settings->typography['font_family'] = $settings->font['family'];
			$settings->typography['font_weight'] = $settings->font['weight'];
		}

		// Handle old alignment settings.
		if ( isset( $settings->alignment ) ) {
			$settings->typography['text_align'] = $settings->alignment;
		}
		if ( isset( $settings->r_alignment ) && 'custom' === $settings->r_alignment ) {
			$settings->typography_responsive['text_align'] = $settings->r_custom_alignment;
		}

		// Handle old font size settings.
		if ( isset( $settings->font_size ) && 'custom' === $settings->font_size ) {
			$settings->typography['font_size'] = array(
				'length' => $settings->custom_font_size,
				'unit'   => 'px',
			);
		}
		if ( isset( $settings->r_font_size ) && 'custom' === $settings->r_font_size ) {
			$settings->typography_responsive['font_size'] = array(
				'length' => $settings->r_custom_font_size,
				'unit'   => 'px',
			);
		}

		// Handle old line height settings.
		if ( isset( $settings->line_height ) && 'custom' === $settings->line_height ) {
			$settings->typography['line_height'] = array(
				'length' => $settings->custom_line_height,
				'unit'   => '',
			);
		}
		if ( isset( $settings->r_line_height ) && 'custom' === $settings->r_line_height ) {
			$settings->typography_responsive['line_height'] = array(
				'length' => $settings->r_custom_line_height,
				'unit'   => '',
			);
		}

		// Handle old letter spacing settings.
		if ( isset( $settings->letter_spacing ) && 'custom' === $settings->letter_spacing ) {
			$settings->typography['letter_spacing'] = array(
				'length' => $settings->custom_letter_spacing,
				'unit'   => 'px',
			);
		}
		if ( isset( $settings->r_letter_spacing ) && 'custom' === $settings->r_letter_spacing ) {
			$settings->typography_responsive['letter_spacing'] = array(
				'length' => $settings->r_custom_letter_spacing,
				'unit'   => 'px',
			);
		}

		// Unset old settings.
		if ( isset( $settings->font ) ) {
			unset( $settings->font );
			unset( $settings->alignment );
			unset( $settings->r_alignment );
			unset( $settings->r_custom_alignment );
			unset( $settings->font_size );
			unset( $settings->custom_font_size );
			unset( $settings->r_font_size );
			unset( $settings->r_custom_font_size );
			unset( $settings->line_height );
			unset( $settings->custom_line_height );
			unset( $settings->r_line_height );
			unset( $settings->r_custom_line_height );
			unset( $settings->letter_spacing );
			unset( $settings->custom_letter_spacing );
			unset( $settings->r_letter_spacing );
			unset( $settings->r_custom_letter_spacing );
		}

		// Return the filtered settings.
		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLRestaurantsMapModule', array(
    'general' => array( // Tab
        'title'    => __('General', 'fl-builder'), // Tab title
        'sections' => array( // Tab Sections
            'general' => array( // Section
                'title'  => __('Section Title', 'fl-builder'), // Section Title
                'fields' => array( // Section Fields
                    'heading'                     => array(
                        'type'         => 'text',
                        'label'        => __('Heading Text', 'fl-builder'),
                        'default'      => '',
                        'class'        => 'my-css-class',
                        'help'         => 'Enter the Heading Text.',
                        'description'  => 'Enter the Heading Text.',
                        'preview'      => array(
							'type'     => 'text',
							'selector' => '.fl-heading-text',
						),
						'connections'  => array( 'string' ),
                    ),
                    'tag'                         => array(
						'type'    => 'select',
						'label'   => __( 'Heading Tag', 'fl-builder' ),
						'default' => 'h2',
						'options' => array(
							'h1' => 'h1',
							'h2' => 'h2',
							'h3' => 'h3',
							'h4' => 'h4',
							'h5' => 'h5',
							'h6' => 'h6',
						),
					),
                    'google_maps_api_key_field'   => array(
                        'type'          => 'text',
                        'label'         => __('Google Maps API Key', 'fl-builder'),
                        'default'       => '',
                        'class'         => 'my-css-class',
                        'help'          => 'Enter the Google Maps API Key.',
                        'description'   => 'Enter the Google Maps API Key.',
                    ),
                    'number_of_map_markers_field' => array(
                        'type'          => 'unit',
                        'label'         => __('Number of Map Markers', 'fl-builder'),
                        'default'       => '4',
                        'help'          => 'Enter a number of map markers.',
                        'description'   => 'Enter a number of map markers.',
                    ),
                )
            )
        )
    ),
    'style'  => array(
        'title' => __( 'Style', 'fl-builder' ),
        'sections' => array(
            'colors' => array(
                'title'  => '',
                'fields' => array(
                    'color'      => array(
                        'type'        => 'color',
                        'connections' => array( 'color' ),
                        'show_reset'  => true,
                        'show_alpha'  => true,
                        'label'       => __( 'Color', 'fl-builder' ),
                        'preview'     => array(
                            'type'      => 'css',
                            'selector'  => '.fl-module-content *',
                            'property'  => 'color',
                            'important' => true,
                        ),
                    ),
                    'typography' => array(
                        'type'       => 'typography',
                        'label'      => __( 'Typography', 'fl-builder' ),
                        'responsive' => true,
                        'preview'    => array(
                            'type'      => 'css',
                            'selector'  => '{node}.fl-module-heading .fl-heading',
                            'important' => true,
                        ),
                    ),
                ),
            ),
        ),
    ),
));