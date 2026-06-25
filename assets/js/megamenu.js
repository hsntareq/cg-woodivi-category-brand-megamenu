/**
 * CG WooDivi Category Brand Megamenu JavaScript
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		initDesktopMegamenu();
		initMobileMegamenu();
	});

	/**
	 * Initialize Desktop Megamenu interactions
	 */
	function initDesktopMegamenu() {
		var hoverTimeout;

		// Hover handler for main navigation dropdowns
		$('.cg-woodivi-nav-item.has-dropdown').hover(
			function() {
				var $this = $(this);
				clearTimeout(hoverTimeout);
				
				// Deactivate other dropdowns
				$('.cg-woodivi-nav-item.has-dropdown').not($this).removeClass('active');
				
				$this.addClass('active');
			},
			function() {
				var $this = $(this);
				hoverTimeout = setTimeout(function() {
					$this.removeClass('active');
				}, 200); // Small delay to prevent accidental closures
			}
		);

		// Prevent links on main dropdown triggers if they contain '#' or are meant only to open the menu
		$('.toggle-dropdown').on('click', function(e) {
			if ($(window).width() > 980) {
				e.preventDefault();
			}
		});

		// Hover handler for sidebar items to switch content panels
		$('.cg-woodivi-sidebar-item').on('mouseenter', function() {
			var $item = $(this);
			var parentId = $item.data('id');
			var $container = $item.closest('.cg-woodivi-dropdown-container');
			
			// Switch active sidebar item
			$container.find('.cg-woodivi-sidebar-item').removeClass('active');
			$item.addClass('active');

			// Switch active content panel
			var $panels = $container.find('.cg-woodivi-content-panel');
			$panels.removeClass('active');
			$panels.filter('[data-id="' + parentId + '"]').addClass('active');
		});
	}

	/**
	 * Initialize Mobile drawer and accordions
	 */
	function initMobileMegamenu() {
		var $trigger = $('.cg-woodivi-mobile-trigger');
		var $drawer  = $('.cg-woodivi-mobile-drawer');
		var $overlay = $('.cg-woodivi-mobile-overlay');
		var $close    = $('.cg-woodivi-mobile-close');

		// Open Drawer
		$trigger.on('click', function() {
			$drawer.addClass('active');
			$overlay.addClass('active');
			$('body').css('overflow', 'hidden'); // Prevent background scrolling
		});

		// Close Drawer
		function closeDrawer() {
			$drawer.removeClass('active');
			$overlay.removeClass('active');
			$('body').css('overflow', '');
		}

		$close.on('click', closeDrawer);
		$overlay.on('click', closeDrawer);

		// Mobile Level 1 Accordion
		$('.cg-woodivi-mobile-link.toggle-accordion').on('click', function(e) {
			e.preventDefault();
			var $link = $(this);
			var $parent = $link.parent();
			var $content = $link.next('.cg-woodivi-mobile-accordion-content');

			$parent.toggleClass('open');
			$content.slideToggle(300);

			// Collapse others at level 1
			$('.cg-woodivi-mobile-item.has-accordion').not($parent).removeClass('open').find('.cg-woodivi-mobile-accordion-content').slideUp(300);
		});

		// Mobile Level 2 Accordion
		$('.toggle-sub-accordion').on('click', function(e) {
			var $link = $(this);
			var $parent = $link.parent();
			var $content = $link.next('.cg-woodivi-mobile-sub-accordion-content');

			if ($content.length > 0) {
				e.preventDefault();
				$parent.toggleClass('open');
				$content.slideToggle(300);
				
				// Collapse other sub-accordions within the same panel
				$parent.siblings('.has-accordion').removeClass('open').find('.cg-woodivi-mobile-sub-accordion-content').slideUp(300);
			}
		});
	}

})(jQuery);
