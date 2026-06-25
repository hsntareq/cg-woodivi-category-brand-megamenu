<?php
/**
 * Demo Data Seeder Class
 *
 * @package CGWooDiviMegamenu
 */

namespace CGWooDiviMegamenu;

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Seeder {

	/**
	 * Seed demo data
	 *
	 * @return true|\WP_Error
	 */
	public static function seed() {
		// Ensure WooCommerce is active
		if ( ! class_exists( 'WooCommerce' ) ) {
			return new \WP_Error( 'woocommerce_inactive', __( 'WooCommerce must be active to seed data.', 'cg-woodivi-category-brand-megamenu' ) );
		}

		// Keep track of terms created
		$created_cats   = get_option( 'cg_woodivi_seeded_categories', array() );
		$created_brands = get_option( 'cg_woodivi_seeded_brands', array() );

		// 1. Seed Categories & Subcategories
		$categories_data = array(
			'Power Tools' => array(
				'Cordless Power Tools', 'Cordless Kits', 'Torches', 'Mitre Saws', 'Multi Tools', 
				'Reciprocating Saws', 'Wood Routers', 'Percussion Drills', 'Air Power Tools', 
				'Combi Drills', 'Circular Saws', 'Plunge Saws', 'Nail Guns & Staple Guns', 
				'Bench Grinders', 'Planers', 'Drill Drivers', 'Site Equipment', 'Angle Grinders', 
				'SDS+ Hammer Drills', 'Impact Wrenches', 'Jigsaws', 'Lathes', 'Vacuum Cleaners', 
				'Diamond Core Drills', 'Welding', 'Impact Drivers', 'SDS Max Hammer Drills', 
				'Laser Levels', 'Jobsite Radios', 'Breakers & Demolition Hammers', 
				'Laser Distance Measurers', 'Chop Saws'
			),
			'Accessories' => array(
				'Drill Bits', 'Screwdriver Bits', 'Saw Blades', 'Abrasives & Sanding', 
				'Batteries & Chargers', 'Tool Bags & Cases'
			),
			'Hand Tools' => array(
				'Screwdrivers', 'Pliers & Cutters', 'Hammers & Demolition', 
				'Wrenches & Spanners', 'Saws & Cutters', 'Measuring & Marking'
			),
			'Screws, Nails & Fixings' => array(
				'Wood Screws', 'Nails', 'Wall Plugs & Anchors', 'Bolts & Nuts'
			),
			'Gardening' => array(
				'Lawnmowers', 'Hedge Trimmers', 'Chainsaws', 'Leaf Blowers', 'Pressure Washers'
			),
			'Sealants & Adhesives' => array(
				'Silicone Sealants', 'Expanding Foam', 'Adhesive Tapes', 'Wood Glue'
			),
			'PPE, Workwear & Safety' => array(
				'Safety Boots', 'Work Trousers', 'Gloves', 'Safety Glasses', 'Ear Protection'
			),
			'Electrical & Lighting' => array(
				'Work Lights', 'Extension Leads', 'Cable Reels', 'Sockets & Switches'
			),
			'Automotive' => array(
				'Car Jacks', 'Socket Sets', 'Battery Chargers', 'Car Cleaning'
			),
			'Heating & Plumbing' => array(
				'Radiators', 'Pipes & Fittings', 'Valves', 'Boilers'
			)
		);

		$cat_term_ids = array(); // Map name -> ID for linking products

		foreach ( $categories_data as $parent_name => $children ) {
			$parent_id = self::get_or_create_term( $parent_name, 'product_cat', 0 );
			if ( is_wp_error( $parent_id ) ) {
				continue;
			}
			$created_cats[] = $parent_id;
			$cat_term_ids[ $parent_name ] = $parent_id;

			foreach ( $children as $child_name ) {
				$child_id = self::get_or_create_term( $child_name, 'product_cat', $parent_id );
				if ( ! is_wp_error( $child_id ) ) {
					$created_cats[] = $child_id;
					$cat_term_ids[ $child_name ] = $child_id;
				}
			}
		}

		// 2. Seed Brands
		$brands_data = array(
			'Milwaukee', 'DeWalt', 'Makita', 'Paslode', 'Stanley', 
			'Hikoki', 'Spit', 'Everbuild', 'Forgefix', 'N-Durance'
		);

		$brand_term_ids = array();

		foreach ( $brands_data as $brand_name ) {
			$brand_id = self::get_or_create_term( $brand_name, 'product_brand', 0 );
			if ( ! is_wp_error( $brand_id ) ) {
				$created_brands[] = $brand_id;
				$brand_term_ids[ $brand_name ] = $brand_id;
			}
		}

		// Save term lists
		update_option( 'cg_woodivi_seeded_categories', array_unique( $created_cats ) );
		update_option( 'cg_woodivi_seeded_brands', array_unique( $created_brands ) );

		// 3. Seed Mock Products (to establish category-brand relationships)
		$mock_products = array(
			// DeWalt
			array(
				'title' => 'DeWalt DCD796 18V XR Brushless Combi Drill',
				'brand' => 'DeWalt',
				'cats'  => array( 'Combi Drills', 'Cordless Power Tools', 'Power Tools' ),
				'price' => '129.99',
			),
			array(
				'title' => 'DeWalt DCS570 18V Brushless Circular Saw',
				'brand' => 'DeWalt',
				'cats'  => array( 'Circular Saws', 'Cordless Power Tools', 'Power Tools' ),
				'price' => '179.99',
			),
			array(
				'title' => 'DeWalt DCK266P2T 18V Brushless Twin Pack Kit',
				'brand' => 'DeWalt',
				'cats'  => array( 'Cordless Kits', 'Power Tools' ),
				'price' => '289.99',
			),
			array(
				'title' => 'DeWalt DW088K Self-Levelling Cross Line Laser',
				'brand' => 'DeWalt',
				'cats'  => array( 'Laser Levels', 'Power Tools' ),
				'price' => '139.99',
			),
			// Milwaukee
			array(
				'title' => 'Milwaukee M18 FPD2 Fuel Combi Drill',
				'brand' => 'Milwaukee',
				'cats'  => array( 'Combi Drills', 'Cordless Power Tools', 'Power Tools' ),
				'price' => '149.99',
			),
			array(
				'title' => 'Milwaukee M18 FIW2F12 Fuel 1/2" Impact Wrench',
				'brand' => 'Milwaukee',
				'cats'  => array( 'Impact Wrenches', 'Cordless Power Tools', 'Power Tools' ),
				'price' => '229.99',
			),
			array(
				'title' => 'Milwaukee Packout Tool Box Case',
				'brand' => 'Milwaukee',
				'cats'  => array( 'Tool Bags & Cases', 'Accessories' ),
				'price' => '79.99',
			),
			// Makita
			array(
				'title' => 'Makita DLX2131JX1 18V Twin Pack Kit',
				'brand' => 'Makita',
				'cats'  => array( 'Cordless Kits', 'Power Tools' ),
				'price' => '259.99',
			),
			array(
				'title' => 'Makita DGA452Z 18V LXT Angle Grinder',
				'brand' => 'Makita',
				'cats'  => array( 'Angle Grinders', 'Cordless Power Tools', 'Power Tools' ),
				'price' => '89.99',
			),
			array(
				'title' => 'Makita SDS+ Hammer Drill Bits Set',
				'brand' => 'Makita',
				'cats'  => array( 'Drill Bits', 'Accessories' ),
				'price' => '24.99',
			),
			// Stanley
			array(
				'title' => 'Stanley Classic 99 Retractable Utility Knife',
				'brand' => 'Stanley',
				'cats'  => array( 'Saws & Cutters', 'Hand Tools' ),
				'price' => '9.99',
			),
			array(
				'title' => 'Stanley Tylon Measuring Tape 8m',
				'brand' => 'Stanley',
				'cats'  => array( 'Measuring & Marking', 'Hand Tools' ),
				'price' => '12.99',
			),
			// Paslode
			array(
				'title' => 'Paslode IM360Xi Lithium Framing Nailer',
				'brand' => 'Paslode',
				'cats'  => array( 'Nail Guns & Staple Guns', 'Power Tools' ),
				'price' => '549.99',
			),
			// Hikoki
			array(
				'title' => 'Hikoki M12VE 1/2" Variable Speed Router',
				'brand' => 'Hikoki',
				'cats'  => array( 'Wood Routers', 'Power Tools' ),
				'price' => '219.99',
			),
			// Everbuild
			array(
				'title' => 'Everbuild EVBGPASGP General Purpose Silicone Clear',
				'brand' => 'Everbuild',
				'cats'  => array( 'Silicone Sealants', 'Sealants & Adhesives' ),
				'price' => '4.99',
			),
			// Forgefix
			array(
				'title' => 'Forgefix MPS3525Y Multi-Purpose Screws 3.5 x 25mm Box 200',
				'brand' => 'Forgefix',
				'cats'  => array( 'Wood Screws', 'Screws, Nails & Fixings' ),
				'price' => '3.49',
			)
		);

		foreach ( $mock_products as $prod ) {
			// Find categories to associate
			$product_cats = array();
			foreach ( $prod['cats'] as $cat_name ) {
				if ( isset( $cat_term_ids[ $cat_name ] ) ) {
					$product_cats[] = (int) $cat_term_ids[ $cat_name ];
				}
			}

			// Find brand to associate
			$product_brands = array();
			if ( isset( $brand_term_ids[ $prod['brand'] ] ) ) {
				$product_brands[] = (int) $brand_term_ids[ $prod['brand'] ];
			}

			// Check if product exists already (by title)
			$existing = get_posts( array(
				'post_type'      => 'product',
				'title'          => $prod['title'],
				'post_status'    => 'any',
				'posts_per_page' => 1,
			) );
			if ( ! empty( $existing ) ) {
				continue;
			}

			// Create product post
			$product_id = wp_insert_post( array(
				'post_title'   => $prod['title'],
				'post_content' => 'Demo product description for ' . $prod['title'],
				'post_status'  => 'publish',
				'post_type'    => 'product',
			) );

			if ( is_wp_error( $product_id ) ) {
				continue;
			}

			// Tag as demo product
			update_post_meta( $product_id, '_cg_woodivi_demo', 1 );

			// WooCommerce Meta
			update_post_meta( $product_id, '_price', $prod['price'] );
			update_post_meta( $product_id, '_regular_price', $prod['price'] );
			update_post_meta( $product_id, '_visibility', 'visible' );
			update_post_meta( $product_id, '_stock_status', 'instock' );

			// Assign terms
			if ( ! empty( $product_cats ) ) {
				wp_set_object_terms( $product_id, $product_cats, 'product_cat' );
			}
			if ( ! empty( $product_brands ) ) {
				wp_set_object_terms( $product_id, $product_brands, 'product_brand' );
			}
		}

		return true;
	}

	/**
	 * Helper to check if a term exists and return its ID, or create it
	 *
	 * @param string $term_name
	 * @param string $taxonomy
	 * @param int $parent_id
	 * @return int|\WP_Error
	 */
	private static function get_or_create_term( $term_name, $taxonomy, $parent_id = 0 ) {
		$term = term_exists( $term_name, $taxonomy, $parent_id );
		
		if ( $term ) {
			return is_array( $term ) ? (int) $term['term_id'] : (int) $term;
		}

		$args = array();
		if ( $parent_id > 0 ) {
			$args['parent'] = $parent_id;
		}

		$new_term = wp_insert_term( $term_name, $taxonomy, $args );

		if ( is_wp_error( $new_term ) ) {
			return $new_term;
		}

		return (int) $new_term['term_id'];
	}

	/**
	 * Clear all demo data
	 *
	 * @return true|\WP_Error
	 */
	public static function clear() {
		// 1. Delete mock products
		$products = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'meta_key'       => '_cg_woodivi_demo',
			'fields'         => 'ids',
		) );

		if ( ! empty( $products ) ) {
			foreach ( $products as $prod_id ) {
				wp_delete_post( $prod_id, true ); // force delete bypasses trash
			}
		}

		// 2. Delete categories seeded
		$seeded_cats = get_option( 'cg_woodivi_seeded_categories', array() );
		if ( ! empty( $seeded_cats ) ) {
			// Sort terms so child terms are deleted before parents to avoid issues
			// Actually, wp_delete_term handles parent re-assignment, but deleting children first is cleaner.
			foreach ( array_reverse( $seeded_cats ) as $cat_id ) {
				wp_delete_term( $cat_id, 'product_cat' );
			}
			delete_option( 'cg_woodivi_seeded_categories' );
		}

		// 3. Delete brands seeded
		$seeded_brands = get_option( 'cg_woodivi_seeded_brands', array() );
		if ( ! empty( $seeded_brands ) ) {
			foreach ( $seeded_brands as $brand_id ) {
				wp_delete_term( $brand_id, 'product_brand' );
			}
			delete_option( 'cg_woodivi_seeded_brands' );
		}

		return true;
	}
}
