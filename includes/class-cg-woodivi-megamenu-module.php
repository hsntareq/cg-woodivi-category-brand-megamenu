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
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\Module\Options\Element\ElementComponents;
use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Options\Element\ElementScriptData;

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
		$container_html = do_shortcode( '[cg_woodivi_megamenu]' );

		return Module::render(
			array(
				// FE only.
				'orderIndex'          => $block->parsed_block['orderIndex'],
				'storeInstance'       => $block->parsed_block['storeInstance'],

				// VB equivalent.
				'attrs'               => $attrs,
				'elements'            => $elements,
				'id'                  => $block->parsed_block['id'],
				'name'                => $block->block_type->name,
				'moduleCategory'      => $block->block_type->category,
				'classnamesFunction'  => array( self::class, 'module_classnames' ),
				'stylesComponent'     => array( self::class, 'module_styles' ),
				'scriptDataComponent' => array( self::class, 'module_script_data' ),
				'parentAttrs'         => array(),
				'parentId'            => '',
				'parentName'          => '',
				'children'            => array(
					ElementComponents::component(
						array(
							'attrs'         => $attrs['module']['decoration'] ?? array(),
							'id'            => $block->parsed_block['id'],

							// FE only.
							'orderIndex'    => $block->parsed_block['orderIndex'],
							'storeInstance' => $block->parsed_block['storeInstance'],
						)
					),
					$container_html,
				),
			)
		);
	}

	/**
	 * Set module classnames
	 */
	public static function module_classnames( $args ) {
		$classnames_instance = $args['classnamesInstance'];
		$classnames_instance->add( 'cg_woodivi_megamenu', true );
	}

	/**
	 * Style compiler
	 */
	public static function module_styles( $args ) {
		$attrs    = $args['attrs'] ?? [];
		$elements = $args['elements'];
		$settings = $args['settings'] ?? [];

		Style::add(
			[
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => [
					$elements->style(
						[
							'attrName'   => 'module',
							'styleProps' => [
								'disabledOn' => [
									'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
								],
							],
						]
					),
					$elements->style( [ 'attrName' => 'navbar' ] ),
					$elements->style( [ 'attrName' => 'navLinks' ] ),
					$elements->style( [ 'attrName' => 'dropdownPanel' ] ),
					$elements->style( [ 'attrName' => 'sidebar' ] ),
					$elements->style( [ 'attrName' => 'sidebarLinks' ] ),
					$elements->style( [ 'attrName' => 'contentPanel' ] ),
					$elements->style( [ 'attrName' => 'sublistLinks' ] ),
					$elements->style( [ 'attrName' => 'ctaButton' ] ),
				],
			]
		);
	}

	/**
	 * Script data
	 */
	public static function module_script_data( $args ) {
		$id             = $args['id'] ?? '';
		$selector       = $args['selector'] ?? '';
		$attrs          = $args['attrs'] ?? [];
		$store_instance = $args['storeInstance'] ?? null;

		$module_decoration_attrs = $attrs['module']['decoration'] ?? [];

		ElementScriptData::set(
			[
				'id'            => $id,
				'selector'      => $selector,
				'attrs'         => array_merge(
					$module_decoration_attrs,
					[
						'link' => $args['attrs']['module']['advanced']['link'] ?? [],
					]
				),
				'storeInstance' => $store_instance,
			]
		);
	}
}
