<?php
/**
 * Native Divi 5 Module registration class for CG WooDivi Category Brand Megamenu
 *
 * @package CGWooDiviMegamenu
 */

namespace CGWooDiviMegamenu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;

class CGWooDiviMegamenuModule implements DependencyInterface {

	/**
	 * Loads the module and registers the Front-End render callback
	 *
	 * @return void
	 */
	public function load() {
		$module_json_folder_path = CG_WOODIVI_MEGAMENU_PATH . 'modules/cg-woodivi-megamenu/';

		if ( class_exists( 'ET\Builder\Packages\ModuleLibrary\ModuleRegistration' ) ) {
			ModuleRegistration::register_module(
				$module_json_folder_path,
				array(
					'render_callback' => array( self::class, 'render_callback' ),
				)
			);
		}
	}

	/**
	 * Render callback for Divi 5 Visual Builder and frontend
	 *
	 * @param array  $attrs    Block attributes saved by VB.
	 * @param string $content  Block content.
	 * @param object $block    Parsed block object.
	 * @param object $elements ModuleElements instance.
	 *
	 * @return string HTML rendered of Megamenu module.
	 */
	public static function render_callback( $attrs, $content, $block, $elements ) {
		return do_shortcode( '[cg_woodivi_megamenu]' );
	}
}
