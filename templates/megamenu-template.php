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
									$children = $data['children'];
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
										
										<!-- Mobile Inline Subcategories Accordion -->
										<div class="cg-woodivi-mobile-inline-sublist">
											<ul class="cg-woodivi-mobile-sublist">
												<?php if ( ! empty( $children ) ) : ?>
													<?php foreach ( $children as $child ) : ?>
														<li class="cg-woodivi-mobile-sublist-item">
															<a href="<?php echo esc_url( get_term_link( $child ) ); ?>">
																<?php echo esc_html( $child->name ); ?>
															</a>
														</li>
													<?php endforeach; ?>
												<?php else : ?>
													<li class="cg-woodivi-mobile-no-data">
														<?php esc_html_e( 'No subcategories available.', 'cg-woodivi-category-brand-megamenu' ); ?>
													</li>
												<?php endif; ?>
												
												<!-- Shop All CTA -->
												<li class="cg-woodivi-mobile-sublist-item cg-woodivi-mobile-cta">
													<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>" class="cg-woodivi-mobile-cta-link">
														<?php echo esc_html( sprintf( 'SHOP ALL %s', strtoupper( html_entity_decode( $parent->name, ENT_QUOTES, 'UTF-8' ) ) ) ); ?>
													</a>
												</li>
											</ul>
										</div>
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
											<?php echo esc_html( sprintf( 'SHOP ALL %s', strtoupper( html_entity_decode( $parent->name, ENT_QUOTES, 'UTF-8' ) ) ) ); ?>
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
								<?php 
								$first_brand = true;
								foreach ( $brands_tree as $parent_id => $data ) : 
									$parent = $data['term'];
									$children = $data['children'];
									$classes = 'cg-woodivi-sidebar-item';
									if ( $first_brand ) {
										$classes .= ' active';
										$first_brand = false;
									}
									?>
									<li class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $parent_id ); ?>">
										<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>">
											<?php echo esc_html( $parent->name ); ?>
											<span class="cg-chevron">&rsaquo;</span>
										</a>
										
										<!-- Mobile Inline Brand Sub-brands Accordion -->
										<div class="cg-woodivi-mobile-inline-sublist">
											<ul class="cg-woodivi-mobile-sublist">
												<?php if ( ! empty( $children ) ) : ?>
													<?php foreach ( $children as $child ) : ?>
														<li class="cg-woodivi-mobile-sublist-item">
															<a href="<?php echo esc_url( get_term_link( $child ) ); ?>">
																<?php echo esc_html( $child->name ); ?>
															</a>
														</li>
													<?php endforeach; ?>
												<?php else : ?>
													<li class="cg-woodivi-mobile-no-data">
														<?php esc_html_e( 'No sub-brands available.', 'cg-woodivi-category-brand-megamenu' ); ?>
													</li>
												<?php endif; ?>
												
												<!-- Brand Store CTA -->
												<li class="cg-woodivi-mobile-sublist-item cg-woodivi-mobile-cta">
													<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>" class="cg-woodivi-mobile-cta-link">
														<?php echo esc_html( sprintf( '%s STORE', strtoupper( html_entity_decode( $parent->name, ENT_QUOTES, 'UTF-8' ) ) ) ); ?>
													</a>
												</li>
											</ul>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
							<div class="cg-woodivi-sidebar-footer">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="cg-woodivi-sidebar-footer-btn">
									<?php esc_html_e( 'SHOP ALL BRANDS', 'cg-woodivi-category-brand-megamenu' ); ?>
								</a>
							</div>
						</div>
						
						<!-- Right Panel (Sub-brands Grid) -->
						<div class="cg-woodivi-content-panels">
							<?php 
							$first_brand = true;
							foreach ( $brands_tree as $parent_id => $data ) : 
								$parent = $data['term'];
								$children = $data['children'];
								$classes = 'cg-woodivi-content-panel';
								if ( $first_brand ) {
									$classes .= ' active';
									$first_brand = false;
								}
								
								// Chunk into up to 3 columns
								$columns = array();
								if ( ! empty( $children ) ) {
									$total = count( $children );
									$items_per_col = ceil( $total / 3 );
									$columns = array_chunk( $children, $items_per_col );
								}
								?>
								<div class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $parent_id ); ?>">
									<div class="cg-woodivi-grid cols-3">
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
												<?php esc_html_e( 'No sub-brands available.', 'cg-woodivi-category-brand-megamenu' ); ?>
											</div>
										<?php endif; ?>
									</div>
									<div class="cg-woodivi-panel-footer">
										<a href="<?php echo esc_url( get_term_link( $parent ) ); ?>" class="cg-woodivi-cta-btn">
											<?php echo esc_html( sprintf( '%s STORE', strtoupper( html_entity_decode( $parent->name, ENT_QUOTES, 'UTF-8' ) ) ) ); ?>
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						
					</div>
				</div>
			</li>
			
		</ul>
	</nav>
</div>
