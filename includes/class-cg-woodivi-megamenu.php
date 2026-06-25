<?php
/**
 * Main Plugin Class
 *
 * @package CGWooDiviMegamenu
 */

namespace CGWooDiviMegamenu;

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	/**
	 * Singleton instance
	 *
	 * @var Plugin
	 */
	private static $instance = null;

	/**
	 * Get singleton instance
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize WordPress hooks
	 */
	private function init_hooks() {
		// Register taxonomies early
		add_action( 'init', array( $this, 'register_brand_taxonomy' ), 5 );

		// Load assets
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		// Shortcode
		add_shortcode( 'cg_woodivi_megamenu', array( $this, 'render_megamenu_shortcode' ) );

		// Divi Integration
		add_action( 'et_builder_ready', array( $this, 'load_divi_module' ), 5 );

		// Admin Menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		// AJAX Actions for Seeding
		add_action( 'wp_ajax_cg_woodivi_seed_demo_data', array( $this, 'ajax_seed_demo_data' ) );
		add_action( 'wp_ajax_cg_woodivi_clear_demo_data', array( $this, 'ajax_clear_demo_data' ) );
	}

	/**
	 * Register Brand Taxonomy if it doesn't exist
	 */
	public function register_brand_taxonomy() {
		if ( ! taxonomy_exists( 'product_brand' ) ) {
			register_taxonomy( 'product_brand', 'product', array(
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => _x( 'Brands', 'taxonomy general name', 'cg-woodivi-category-brand-megamenu' ),
					'singular_name'     => _x( 'Brand', 'taxonomy singular name', 'cg-woodivi-category-brand-megamenu' ),
					'search_items'      => __( 'Search Brands', 'cg-woodivi-category-brand-megamenu' ),
					'all_items'         => __( 'All Brands', 'cg-woodivi-category-brand-megamenu' ),
					'parent_item'       => __( 'Parent Brand', 'cg-woodivi-category-brand-megamenu' ),
					'parent_item_colon' => __( 'Parent Brand:', 'cg-woodivi-category-brand-megamenu' ),
					'edit_item'         => __( 'Edit Brand', 'cg-woodivi-category-brand-megamenu' ),
					'update_item'       => __( 'Update Brand', 'cg-woodivi-category-brand-megamenu' ),
					'add_new_item'      => __( 'Add New Brand', 'cg-woodivi-category-brand-megamenu' ),
					'new_item_name'     => __( 'New Brand Name', 'cg-woodivi-category-brand-megamenu' ),
					'menu_name'         => __( 'Brands', 'cg-woodivi-category-brand-megamenu' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'brand' ),
			) );
		}
	}

	/**
	 * Enqueue assets for frontend
	 */
	public function enqueue_frontend_assets() {
		wp_enqueue_style(
			'cg-woodivi-megamenu',
			CG_WOODIVI_MEGAMENU_URL . 'assets/css/megamenu.css',
			array(),
			CG_WOODIVI_MEGAMENU_VERSION
		);

		wp_enqueue_script(
			'cg-woodivi-megamenu',
			CG_WOODIVI_MEGAMENU_URL . 'assets/js/megamenu.js',
			array( 'jquery' ),
			CG_WOODIVI_MEGAMENU_VERSION,
			true
		);

		// Localize for any AJAX actions or script settings
		wp_localize_script(
			'cg-woodivi-megamenu',
			'cgWooDiviMegamenu',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'cg-woodivi-megamenu-nonce' ),
			)
		);
	}

	/**
	 * Enqueue assets for WP Admin
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( 'woocommerce_page_cg-woodivi-megamenu' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'cg-woodivi-megamenu-admin',
			CG_WOODIVI_MEGAMENU_URL . 'assets/css/admin.css',
			array(),
			CG_WOODIVI_MEGAMENU_VERSION
		);
	}

	/**
	 * Load Classic Divi module
	 */
	public function load_divi_module() {
		if ( class_exists( 'ET_Builder_Module' ) ) {
			require_once CG_WOODIVI_MEGAMENU_PATH . 'includes/class-cg-woodivi-divi-module.php';
		}
	}

	/**
	 * Add admin settings page under WooCommerce menu
	 */
	public function add_admin_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'CG Megamenu', 'cg-woodivi-category-brand-megamenu' ),
			__( 'CG Megamenu', 'cg-woodivi-category-brand-megamenu' ),
			'manage_options',
			'cg-woodivi-megamenu',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		// Check counts
		$categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		$category_count = is_wp_error( $categories ) ? 0 : count( $categories );

		$brands = get_terms( array(
			'taxonomy'   => 'product_brand',
			'hide_empty' => false,
		) );
		$brand_count = is_wp_error( $brands ) ? 0 : count( $brands );

		// Count mock products
		$products = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
			'meta_key'       => '_cg_woodivi_demo',
		) );
		$product_count = count( $products );

		?>
		<div class="wrap cg-woodivi-admin-wrap">
			<h1><?php esc_html_e( 'CG WooDivi Megamenu Settings', 'cg-woodivi-category-brand-megamenu' ); ?></h1>
			
			<div class="card">
				<h2><?php esc_html_e( 'Seeding & Demo Data', 'cg-woodivi-category-brand-megamenu' ); ?></h2>
				<p><?php esc_html_e( 'This section allows you to manage the demo categories, brands, and products for the megamenu. Ideal for setting up a shop that mirrors Toolden.co.uk when no data is available.', 'cg-woodivi-category-brand-megamenu' ); ?></p>
				
				<div class="cg-woodivi-stats">
					<p><strong><?php esc_html_e( 'Total Product Categories:', 'cg-woodivi-category-brand-megamenu' ); ?></strong> <?php echo esc_html( $category_count ); ?></p>
					<p><strong><?php esc_html_e( 'Total Product Brands:', 'cg-woodivi-category-brand-megamenu' ); ?></strong> <?php echo esc_html( $brand_count ); ?></p>
					<p><strong><?php esc_html_e( 'Total Mock Products Seeded:', 'cg-woodivi-category-brand-megamenu' ); ?></strong> <?php echo esc_html( $product_count ); ?></p>
				</div>

				<div class="cg-woodivi-actions" style="margin-top: 20px;">
					<button id="cg-woodivi-seed-btn" class="button button-primary button-large" data-nonce="<?php echo esc_attr( wp_create_nonce( 'cg-woodivi-seed-nonce' ) ); ?>">
						<?php esc_html_e( 'Generate Demo Data', 'cg-woodivi-category-brand-megamenu' ); ?>
					</button>
					
					<button id="cg-woodivi-clear-btn" class="button button-secondary button-large" style="margin-left: 10px;" data-nonce="<?php echo esc_attr( wp_create_nonce( 'cg-woodivi-seed-nonce' ) ); ?>">
						<?php esc_html_e( 'Clear Demo Data', 'cg-woodivi-category-brand-megamenu' ); ?>
					</button>
					<span class="spinner" style="float: none; margin: 4px 10px 0;"></span>
				</div>
				
				<div id="cg-woodivi-message" style="margin-top: 15px; font-weight: bold;"></div>
			</div>

			<div class="card">
				<h2><?php esc_html_e( 'Shortcode Usage', 'cg-woodivi-category-brand-megamenu' ); ?></h2>
				<p><?php esc_html_e( 'Use the following shortcode to place the megamenu in any text, code block, or page layout:', 'cg-woodivi-category-brand-megamenu' ); ?></p>
				<code>[cg_woodivi_megamenu]</code>
				
				<h3 style="margin-top: 20px;"><?php esc_html_e( 'Divi Builder', 'cg-woodivi-category-brand-megamenu' ); ?></h3>
				<p><?php esc_html_e( 'Alternatively, search for "CG WooDivi Category Brand Megamenu" in the Divi Builder module list to insert it natively.', 'cg-woodivi-category-brand-megamenu' ); ?></p>
			</div>

			<script>
				jQuery(document).ready(function($) {
					var $seedBtn = $('#cg-woodivi-seed-btn');
					var $clearBtn = $('#cg-woodivi-clear-btn');
					var $spinner = $('.spinner');
					var $msg = $('#cg-woodivi-message');

					$seedBtn.on('click', function() {
						if (!confirm('Are you sure you want to generate demo product categories, brands, and products?')) {
							return;
						}
						
						$seedBtn.prop('disabled', true);
						$clearBtn.prop('disabled', true);
						$spinner.addClass('is-active');
						$msg.text('Generating demo data... This might take a few moments.').css('color', '#000');

						$.post(ajaxurl, {
							action: 'cg_woodivi_seed_demo_data',
							nonce: $seedBtn.data('nonce')
						}, function(res) {
							$spinner.removeClass('is-active');
							$seedBtn.prop('disabled', false);
							$clearBtn.prop('disabled', false);
							
							if (res.success) {
								$msg.text(res.data.message).css('color', 'green');
								setTimeout(function() {
									location.reload();
								}, 1500);
							} else {
								$msg.text(res.data.message || 'Error occurred.').css('color', 'red');
							}
						}).fail(function() {
							$spinner.removeClass('is-active');
							$seedBtn.prop('disabled', false);
							$clearBtn.prop('disabled', false);
							$msg.text('Server error occurred. Please try again.').css('color', 'red');
						});
					});

					$clearBtn.on('click', function() {
						if (!confirm('Are you sure you want to clear ALL seeded demo data? This will remove mock products, and the demo terms created by this plugin.')) {
							return;
						}
						
						$seedBtn.prop('disabled', true);
						$clearBtn.prop('disabled', true);
						$spinner.addClass('is-active');
						$msg.text('Clearing demo data...').css('color', '#000');

						$.post(ajaxurl, {
							action: 'cg_woodivi_clear_demo_data',
							nonce: $clearBtn.data('nonce')
						}, function(res) {
							$spinner.removeClass('is-active');
							$seedBtn.prop('disabled', false);
							$clearBtn.prop('disabled', false);
							
							if (res.success) {
								$msg.text(res.data.message).css('color', 'green');
								setTimeout(function() {
									location.reload();
								}, 1500);
							} else {
								$msg.text(res.data.message || 'Error occurred.').css('color', 'red');
							}
						}).fail(function() {
							$spinner.removeClass('is-active');
							$seedBtn.prop('disabled', false);
							$clearBtn.prop('disabled', false);
							$msg.text('Server error occurred. Please try again.').css('color', 'red');
						});
					});
				});
			</script>
		</div>
		<?php
	}

	/**
	 * AJAX handler: Seed Demo Data
	 */
	public function ajax_seed_demo_data() {
		check_ajax_referer( 'cg-woodivi-seed-nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized user.' ) );
		}

		$result = Seeder::seed();

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} else {
			wp_send_json_success( array( 'message' => 'Demo data generated successfully!' ) );
		}
	}

	/**
	 * AJAX handler: Clear Demo Data
	 */
	public function ajax_clear_demo_data() {
		check_ajax_referer( 'cg-woodivi-seed-nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Unauthorized user.' ) );
		}

		$result = Seeder::clear();

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} else {
			wp_send_json_success( array( 'message' => 'Demo data cleared successfully!' ) );
		}
	}

	/**
	 * Render Megamenu Shortcode
	 */
	public function render_megamenu_shortcode( $atts ) {
		// Enqueue scripts dynamically just in case
		if ( ! wp_script_is( 'cg-woodivi-megamenu', 'enqueued' ) ) {
			$this->enqueue_frontend_assets();
		}

		// Fetch Categories Tree
		$categories_tree = $this->get_categories_tree();

		// Fetch Brands
		$brands = $this->get_brands_list();

		// Start Output Buffer
		ob_start();
		
		// Include template
		$template_path = CG_WOODIVI_MEGAMENU_PATH . 'templates/megamenu-template.php';
		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<p>Megamenu template not found.</p>';
		}

		return ob_get_clean();
	}

	/**
	 * Get WooCommerce Product Categories structured hierarchy
	 *
	 * @return array
	 */
	public function get_categories_tree() {
		$terms = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return array();
		}

		$parents = array();
		$children = array();

		// Exclude "Uncategorized" from top level if needed, but let's just structure all terms
		foreach ( $terms as $term ) {
			if ( 'uncategorized' === strtolower( $term->slug ) ) {
				continue;
			}

			if ( 0 === (int) $term->parent ) {
				$parents[ $term->term_id ] = array(
					'term'     => $term,
					'children' => array(),
				);
			} else {
				$children[] = $term;
			}
		}

		// Map child terms to parent terms
		foreach ( $children as $child ) {
			if ( isset( $parents[ $child->parent ] ) ) {
				$parents[ $child->parent ]['children'][] = $child;
			} else {
				// Grandchild or unmapped parent. For our 2-level layout, we can map to the top level parent or check parents chain
				// Let's resolve the ultimate top level parent
				$top_parent_id = $this->get_top_level_parent_id( $child->parent );
				if ( $top_parent_id && isset( $parents[ $top_parent_id ] ) ) {
					$parents[ $top_parent_id ]['children'][] = $child;
				}
			}
		}

		// Sort child arrays by name
		foreach ( $parents as $id => $data ) {
			if ( ! empty( $data['children'] ) ) {
				usort( $parents[ $id ]['children'], function( $a, $b ) {
					return strcmp( $a->name, $b->name );
				} );
			}
		}

		// Filter out parents that have no children to keep the sidebar clean (unless we want to display empty ones)
		// Actually, let's keep all parents, but if they have children, it's a dropdown megamenu.
		return $parents;
	}

	/**
	 * Recursive helper to get top-level parent term ID
	 *
	 * @param int $term_id
	 * @return int
	 */
	private function get_top_level_parent_id( $term_id ) {
		$term = get_term( $term_id, 'product_cat' );
		if ( is_wp_error( $term ) || ! $term ) {
			return 0;
		}
		if ( 0 === (int) $term->parent ) {
			return $term->term_id;
		}
		return $this->get_top_level_parent_id( $term->parent );
	}

	/**
	 * Get WooCommerce Product Brands List
	 *
	 * @return array
	 */
	public function get_brands_list() {
		$brands = get_terms( array(
			'taxonomy'   => 'product_brand',
			'hide_empty' => false,
		) );

		if ( is_wp_error( $brands ) || empty( $brands ) ) {
			return array();
		}

		return $brands;
	}

	/**
	 * Get categories containing products for a specific brand
	 *
	 * @param int $brand_id
	 * @return array
	 */
	public static function get_brand_categories( $brand_id ) {
		global $wpdb;

		// Fetch distinct product_cat term_ids of products that are in the specified product_brand
		$query = $wpdb->prepare(
			"SELECT DISTINCT t.term_id, t.name, t.slug, tt.parent
			 FROM {$wpdb->terms} t
			 INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
			 INNER JOIN {$wpdb->term_relationships} tr1 ON tt.term_taxonomy_id = tr1.term_taxonomy_id
			 INNER JOIN {$wpdb->term_relationships} tr2 ON tr1.object_id = tr2.object_id
			 INNER JOIN {$wpdb->term_taxonomy} tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id
			 WHERE tt.taxonomy = 'product_cat'
			 AND tt2.taxonomy = 'product_brand'
			 AND tt2.term_id = %d",
			$brand_id
		);

		$results = $wpdb->get_results( $query );

		if ( empty( $results ) ) {
			// Fallback: If no products are linked, return subcategories of "Power Tools" (or first categories) as demo layout
			// But since we seed products, this fallback is rarely needed.
			return array();
		}

		// Let's filter out parent categories (parent == 0) to only show subcategories in the Brand grid
		$subcategories = array();
		foreach ( $results as $row ) {
			if ( (int) $row->parent > 0 ) {
				$subcategories[] = $row;
			}
		}

		// If no subcategories found, return all results
		return ! empty( $subcategories ) ? $subcategories : $results;
	}
}
