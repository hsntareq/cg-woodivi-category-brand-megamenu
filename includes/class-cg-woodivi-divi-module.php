<?php
/**
 * Classic Divi Builder Module for CG WooDivi Category Brand Megamenu
 *
 * @package CGWooDiviMegamenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ET_Builder_Module_CG_WooDivi_Megamenu extends ET_Builder_Module {

	/**
	 * Module slug
	 */
	public $slug = 'et_pb_cg_woodivi_megamenu';

	/**
	 * Module name
	 */
	public $name = 'CG WooDivi Category Brand Megamenu';

	/**
	 * Visual Builder support
	 */
	public $vb_support = 'on';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get module fields config
	 */
	public function get_fields() {
		return array(
			// No options required since it is a self-contained category/brand megamenu.
		);
	}

	/**
	 * Get advanced fields config
	 */
	public function get_advanced_fields_config() {
		return array(
			'fonts'       => false,
			'text'        => false,
			'text_shadow' => false,
			'background'  => false,
			'border'      => false,
			'box_shadow'  => false,
			'margin_padding' => false,
		);
	}

	/**
	 * Render module
	 */
	public function render( $attrs, $content = null, $render_slug = null ) {
		return do_shortcode( '[cg_woodivi_megamenu]' );
	}
}

// Register the module with Divi
if ( class_exists( 'ET_Builder_Module' ) ) {
	add_action( 'wp_loaded', function() {
		global $et_builder_modules;
		if ( ! is_array( $et_builder_modules ) ) {
			$et_builder_modules = array();
		}
		$et_builder_modules['ET_Builder_Module_CG_WooDivi_Megamenu'] = 'ET_Builder_Module_CG_WooDivi_Megamenu';
	}, 20 );
}
new ET_Builder_Module_CG_WooDivi_Megamenu();
