<?php
/**
 * Plugin Name: CG WooDivi Category Brand Megamenu
 * Plugin URI: https://github.com/hsntareq/cg-woodivi-category-brand-megamenu
 * Description: A premium, dynamic WooCommerce megamenu plugin with Category & Brand lists, designed like Toolden.co.uk. Compatible with Divi Builder.
 * Version: 1.0.5
 * Author: Hasan Tareq
 * Author URI: https://github.com/hsntareq
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cg-woodivi-category-brand-megamenu
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 *
 * @package CGWooDiviMegamenu
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access forbidden.' );
}

// Define plugin constants
define( 'CG_WOODIVI_MEGAMENU_VERSION', '1.0.5' );
define( 'CG_WOODIVI_MEGAMENU_PATH', plugin_dir_path( __FILE__ ) );
define( 'CG_WOODIVI_MEGAMENU_URL', plugin_dir_url( __FILE__ ) );
define( 'CG_WOODIVI_MEGAMENU_BASENAME', plugin_basename( __FILE__ ) );

// Include required classes
require_once CG_WOODIVI_MEGAMENU_PATH . 'includes/class-cg-woodivi-megamenu.php';
require_once CG_WOODIVI_MEGAMENU_PATH . 'includes/class-cg-woodivi-seeder.php';

// Initialize the plugin
add_action( 'plugins_loaded', function() {
	\CGWooDiviMegamenu\Plugin::get_instance();
} );

// Register activation hook for registering taxonomies and setting up defaults
register_activation_hook( __FILE__, function() {
	// Register taxonomies if they don't exist yet (to avoid issues during activation hooks)
	if ( ! taxonomy_exists( 'product_brand' ) ) {
		register_taxonomy( 'product_brand', 'product', array(
			'hierarchical' => true,
			'label'        => 'Brands',
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array( 'slug' => 'brand' ),
		) );
	}
	flush_rewrite_rules();
} );
