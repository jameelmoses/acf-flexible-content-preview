<?php
/*
 Plugin Name: Flexible Content Preview for Advanced Custom Fields
 Version: 1.0.6
 Plugin URI: https://github.com/jameelmoses/acf-flexible-content-preview
 Description: Transforms ACF's flexible content field's layout list into a modal with image previews.
 Author: Jameel Moses
 Author URI: https://github.com/jameelmoses
 Text Domain: acf-flexible-content-preview
 Contributors: Ben Voynick

 ----

 Copyright 2021 Jameel Moses and contributors

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'FCP_VERSION', '1.0.6' );
define( 'FCP_MIN_PHP_VERSION', '5.6' );

// Plugin URL and PATH
define( 'FCP_URL', plugin_dir_url( __FILE__ ) );
define( 'FCP_DIR', plugin_dir_path( __FILE__ ) );
define( 'FCP_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );

// Check PHP min version
if ( version_compare( PHP_VERSION, FCP_MIN_PHP_VERSION, '<' ) ) {
	require_once( FCP_DIR . 'compat.php' );

	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'FCP\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

/** Autoload */
require_once FCP_DIR . 'autoload.php';

add_action( 'plugins_loaded', 'plugins_loaded_acf_flexible_content_preview' );
/** Init the plugin */
function plugins_loaded_acf_flexible_content_preview() {
	$requirements = \FCP\Requirements::get_instance();
	if ( ! $requirements->check_requirements() ) {
		return;
	}

	// Client
	\FCP\Main::get_instance();
}
