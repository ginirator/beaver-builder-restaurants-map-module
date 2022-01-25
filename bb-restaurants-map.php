<?php
/*
Plugin Name: Beaver Builder - Restaurants Map Module
Plugin URI: https://dodon.name/bbmodules/restaurants-map-module/
Description: Beaver Builder - Restaurants Map Module
Version: 1.0.0
Author: Valeriu Dodon
Author URI: https://dodon.name
Licence: GPL2
*/

/**
 * This WordPress plugin is a Restaurants Map module that will be included in the Beaver Builder plugin.
 * Copyright 2022 Ⓒ Valeriu Dodon. All rights reserved.
*/

define( 'FL_MODULE_RESTAURANTS_MAP_DIR', plugin_dir_path( __FILE__ ) );
define( 'FL_MODULE_RESTAURANTS_MAP_URL', plugins_url( '/', __FILE__ ) );

require_once FL_MODULE_RESTAURANTS_MAP_DIR . 'classes/class-fl-restaurants-map-modules-loader.php';
