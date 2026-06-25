<?php
/**
 * Megamenu Frontend Template
 *
 * @package CGWooDiviMegamenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cg-woodivi-megamenu-wrapper">
	<!-- Navigation Menu Bar -->
	<nav class="cg-woodivi-navbar">
		<ul class="cg-woodivi-nav-list">
			
			<!-- Shop By Category Nav Link -->
			<li class="cg-woodivi-nav-item has-dropdown" data-target="category">
				<a href="#" class="cg-woodivi-nav-link toggle-dropdown">
					<?php esc_html_e( 'SHOP BY CATEGORY', 'cg-woodivi-category-brand-megamenu' ); ?>
					<span class="cg-arrow cg-arrow-down">&#9662;</span>
				</a>
				
				<!-- Category Megamenu Dropdown -->
				<div class="cg-woodivi-dropdown-panel" id="cg-panel-category">
					<div class="cg-woodivi-dropdown-container">
						
						<!-- Left Sidebar (Parent Categories) -->
						<div class="cg-woodivi-sidebar">
							<ul class="cg-woodivi-sidebar-list">
								<?php 
								$first_cat = true;
								foreach ( $categories_tree as $parent_id => $data ) : 
									$parent = $data['term'];
									$classes = 'cg-woodivi-sidebar-item';
									if ( $first_cat ) {
										$classes .= ' active';
										$first_cat = false;
									}
									?>
									<li class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $parent_id ); ?>">
										<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>">
											<?php echo esc_html( $parent->name ); ?>
											<span class="cg-chevron">&rsaquo;</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						
						<!-- Right Panel (Subcategories Grid) -->
						<div class="cg-woodivi-content-panels">
							<?php 
							$first_cat = true;
							foreach ( $categories_tree as $parent_id => $data ) : 
								$parent = $data['term'];
								$children = $data['children'];
								$classes = 'cg-woodivi-content-panel';
								if ( $first_cat ) {
									$classes .= ' active';
									$first_cat = false;
								}
								
								// Chunk children into up to 4 columns
								$columns = array();
								if ( ! empty( $children ) ) {
									$total = count( $children );
									$items_per_col = ceil( $total / 4 );
									$columns = array_chunk( $children, $items_per_col );
								}
								?>
								<div class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $parent_id ); ?>">
									<div class="cg-woodivi-grid cols-4">
										<?php if ( ! empty( $columns ) ) : ?>
											<?php foreach ( $columns as $col ) : ?>
												<div class="cg-woodivi-col">
													<ul class="cg-woodivi-sublist">
														<?php foreach ( $col as $child ) : ?>
															<li class="cg-woodivi-sublist-item">
																<a href="<?php echo esc_url( get_term_link( $child ) ); ?>">
																	<?php echo esc_html( $child->name ); ?>
																</a>
															</li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endforeach; ?>
										<?php else : ?>
											<div class="cg-woodivi-no-data">
												<?php esc_html_e( 'No subcategories available.', 'cg-woodivi-category-brand-megamenu' ); ?>
											</div>
										<?php endif; ?>
									</div>
									<div class="cg-woodivi-panel-footer">
										<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>" class="cg-woodivi-cta-btn">
											<?php echo esc_html( sprintf( 'SHOP ALL %s', strtoupper( $parent->name ) ) ); ?>
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						
					</div>
				</div>
			</li>
			
			<!-- Shop By Brand Nav Link -->
			<li class="cg-woodivi-nav-item has-dropdown" data-target="brand">
				<a href="#" class="cg-woodivi-nav-link toggle-dropdown">
					<?php esc_html_e( 'SHOP BY BRAND', 'cg-woodivi-category-brand-megamenu' ); ?>
					<span class="cg-arrow cg-arrow-right">&#9656;</span>
				</a>
				
				<!-- Brand Megamenu Dropdown -->
				<div class="cg-woodivi-dropdown-panel" id="cg-panel-brand">
					<div class="cg-woodivi-dropdown-container">
						
						<!-- Left Sidebar (Brands List) -->
						<div class="cg-woodivi-sidebar">
							<ul class="cg-woodivi-sidebar-list">
								<li class="cg-woodivi-sidebar-header"><?php esc_html_e( 'TOP BRANDS', 'cg-woodivi-category-brand-megamenu' ); ?></li>
								<?php 
								$first_brand = true;
								foreach ( $brands as $brand ) : 
									$classes = 'cg-woodivi-sidebar-item';
									if ( $first_brand ) {
										$classes .= ' active';
										$first_brand = false;
									}
									?>
									<li class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $brand->term_id ); ?>">
										<a href="<?php echo esc_url( get_term_link( $brand ) ); ?>">
											<?php echo esc_html( $brand->name ); ?>
											<span class="cg-chevron">&rsaquo;</span>
										</a>
									</li>
								<?php endforeach; ?>
								
								<li class="cg-woodivi-sidebar-footer-link">
									<a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>">
										<?php esc_html_e( 'SHOP ALL BRANDS', 'cg-woodivi-category-brand-megamenu' ); ?>
									</a>
								</li>
							</ul>
						</div>
						
						<!-- Right Panel (Brand Categories Grid) -->
						<div class="cg-woodivi-content-panels">
							<?php 
							$first_brand = true;
							foreach ( $brands as $brand ) : 
								$classes = 'cg-woodivi-content-panel';
								if ( $first_brand ) {
									$classes .= ' active';
									$first_brand = false;
								}
								
								// Get categories under this brand
								$brand_cats = \CGWooDiviMegamenu\Plugin::get_brand_categories( $brand->term_id );
								
								// Chunk into up to 3 columns
								$columns = array();
								if ( ! empty( $brand_cats ) ) {
									$total = count( $brand_cats );
									$items_per_col = ceil( $total / 3 );
									$columns = array_chunk( $brand_cats, $items_per_col );
								}
								?>
								<div class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $brand->term_id ); ?>">
									<div class="cg-woodivi-grid cols-3">
										<?php if ( ! empty( $columns ) ) : ?>
											<?php foreach ( $columns as $col ) : ?>
												<div class="cg-woodivi-col">
													<ul class="cg-woodivi-sublist">
														<?php foreach ( $col as $cat ) : ?>
															<li class="cg-woodivi-sublist-item">
																<a href="<?php echo esc_url( get_term_link( (int) $cat->term_id, 'product_cat' ) ); ?>?filter_brand=<?php echo esc_attr( $brand->slug ); ?>">
																	<?php echo esc_html( $cat->name ); ?>
																</a>
															</li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endforeach; ?>
										<?php else : ?>
											<div class="cg-woodivi-no-data">
												<?php esc_html_e( 'No categories found for this brand.', 'cg-woodivi-category-brand-megamenu' ); ?>
											</div>
										<?php endif; ?>
									</div>
									<div class="cg-woodivi-panel-footer">
										<a href="<?php echo esc_url( get_term_link( $brand ) ); ?>" class="cg-woodivi-cta-btn">
											<?php echo esc_html( sprintf( '%s STORE', strtoupper( $brand->name ) ) ); ?>
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						
					</div>
				</div>
			</li>
			
			<!-- Kit Builder Link -->
			<li class="cg-woodivi-nav-item cg-woodivi-custom-link">
				<a href="#" class="cg-woodivi-nav-link btn-orange"><?php esc_html_e( 'KIT BUILDER', 'cg-woodivi-category-brand-megamenu' ); ?></a>
			</li>
			
			<!-- Offers Link -->
			<li class="cg-woodivi-nav-item cg-woodivi-custom-link">
				<a href="#" class="cg-woodivi-nav-link btn-red"><?php esc_html_e( 'OFFERS', 'cg-woodivi-category-brand-megamenu' ); ?></a>
			</li>
			
		</ul>

		<!-- Mobile Menu Trigger -->
		<div class="cg-woodivi-mobile-trigger">
			<span class="cg-bar"></span>
			<span class="cg-bar"></span>
			<span class="cg-bar"></span>
		</div>
	</nav>

	<!-- Mobile Drawer -->
	<div class="cg-woodivi-mobile-drawer">
		<div class="cg-woodivi-mobile-drawer-header">
			<h3><?php esc_html_e( 'SHOP MENU', 'cg-woodivi-category-brand-megamenu' ); ?></h3>
			<button class="cg-woodivi-mobile-close">&times;</button>
		</div>
		<div class="cg-woodivi-mobile-drawer-body">
			<ul class="cg-woodivi-mobile-nav">
				
				<!-- Mobile Category Accordion -->
				<li class="cg-woodivi-mobile-item has-accordion">
					<a href="#" class="cg-woodivi-mobile-link toggle-accordion">
						<?php esc_html_e( 'SHOP BY CATEGORY', 'cg-woodivi-category-brand-megamenu' ); ?>
						<span class="cg-mob-arrow">&#9662;</span>
					</a>
					<ul class="cg-woodivi-mobile-accordion-content">
						<?php foreach ( $categories_tree as $parent_id => $data ) : 
							$parent = $data['term'];
							$children = $data['children'];
							?>
							<li class="cg-woodivi-mobile-sub-item <?php echo ! empty( $children ) ? 'has-accordion' : ''; ?>">
								<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>" class="toggle-sub-accordion">
									<?php echo esc_html( $parent->name ); ?>
									<?php if ( ! empty( $children ) ) : ?><span class="cg-mob-arrow">&#9662;</span><?php endif; ?>
								</a>
								<?php if ( ! empty( $children ) ) : ?>
									<ul class="cg-woodivi-mobile-sub-accordion-content">
										<?php foreach ( $children as $child ) : ?>
											<li>
												<a href="<?php echo esc_url( get_term_link( $child ) ); ?>">
													<?php echo esc_html( $child->name ); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
				
				<!-- Mobile Brand Accordion -->
				<li class="cg-woodivi-mobile-item has-accordion">
					<a href="#" class="cg-woodivi-mobile-link toggle-accordion">
						<?php esc_html_e( 'SHOP BY BRAND', 'cg-woodivi-category-brand-megamenu' ); ?>
						<span class="cg-mob-arrow">&#9662;</span>
					</a>
					<ul class="cg-woodivi-mobile-accordion-content">
						<?php foreach ( $brands as $brand ) : 
							$brand_cats = \CGWooDiviMegamenu\Plugin::get_brand_categories( $brand->term_id );
							?>
							<li class="cg-woodivi-mobile-sub-item <?php echo ! empty( $brand_cats ) ? 'has-accordion' : ''; ?>">
								<a href="<?php echo esc_url( get_term_link( $brand ) ); ?>" class="toggle-sub-accordion">
									<?php echo esc_html( $brand->name ); ?>
									<?php if ( ! empty( $brand_cats ) ) : ?><span class="cg-mob-arrow">&#9662;</span><?php endif; ?>
								</a>
								<?php if ( ! empty( $brand_cats ) ) : ?>
									<ul class="cg-woodivi-mobile-sub-accordion-content">
										<?php foreach ( $brand_cats as $cat ) : ?>
											<li>
												<a href="<?php echo esc_url( get_term_link( (int) $cat->term_id, 'product_cat' ) ); ?>?filter_brand=<?php echo esc_attr( $brand->slug ); ?>">
													<?php echo esc_html( $cat->name ); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
						<li>
							<a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>">
								<strong><?php esc_html_e( 'SHOP ALL BRANDS', 'cg-woodivi-category-brand-megamenu' ); ?></strong>
							</a>
						</li>
					</ul>
				</li>

				<!-- Mobile Custom Links -->
				<li class="cg-woodivi-mobile-item">
					<a href="#" class="cg-woodivi-mobile-link mob-btn-orange"><?php esc_html_e( 'KIT BUILDER', 'cg-woodivi-category-brand-megamenu' ); ?></a>
				</li>
				<li class="cg-woodivi-mobile-item">
					<a href="#" class="cg-woodivi-mobile-link mob-btn-red"><?php esc_html_e( 'OFFERS', 'cg-woodivi-category-brand-megamenu' ); ?></a>
				</li>

			</ul>
		</div>
	</div>
	<!-- Mobile Drawer Overlay -->
	<div class="cg-woodivi-mobile-overlay"></div>
</div>
