<?php
/**
 * A class that handles loading restaurants map modules.
 */
class FL_Restaurants_Map_Modules_Example_Loader {

	/**
	 * Initializes the class once all plugins have loaded.
	 */
	static public function init() {
		add_action( 'plugins_loaded', __CLASS__ . '::setup_hooks' );
	}

	/**
	 * Setup hooks if the builder is installed and activated.
	 */
	static public function setup_hooks() {
		if ( ! class_exists( 'FLBuilder' ) ) {
			return;
		}

		// Load modules.
		add_action( 'init', __CLASS__ . '::load_modules' );

		// Enqueue field assets.
		add_action( 'init', __CLASS__ . '::enqueue_field_assets' );
	}

	/**
	 * Loads our modules.
	 */
	static public function load_modules() {
		require_once FL_MODULE_RESTAURANTS_MAP_DIR . 'modules/restaurants-map/restaurants-map.php';
	}

	/**
	 * Enqueues our field assets only if the builder UI is active.
	 */
	static public function enqueue_field_assets() {
		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		}

		wp_enqueue_style( 'my-restaurants-map-fields', FL_MODULE_RESTAURANTS_MAP_URL . 'assets/css/fields.css', array(), '' );
		wp_enqueue_script( 'my-restaurants-map-fields', FL_MODULE_RESTAURANTS_MAP_URL . 'assets/js/fields.js', array(), '', true );
	}
}

FL_Restaurants_Map_Modules_Example_Loader::init();
