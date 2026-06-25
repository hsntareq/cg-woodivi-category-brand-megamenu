import './components/cg-woodivi-megamenu/module.scss';

const initMegamenu = () => {
  const $ = (window as any).jQuery;
  if (!$) return;

  // Initialize Desktop Megamenu interactions
  const initDesktopMegamenu = () => {
    // Click handler for main navigation dropdowns
    $('.cg-woodivi-nav-item.has-dropdown > .cg-woodivi-nav-link').on('click', function(this: HTMLElement, e: any) {
      e.preventDefault();
      e.stopPropagation();
      
      const $item = $(this).parent('.cg-woodivi-nav-item');
      
      // Deactivate other dropdowns
      $('.cg-woodivi-nav-item.has-dropdown').not($item).removeClass('active');
      
      // Toggle active class on clicked dropdown
      $item.toggleClass('active');

      // Toggle body class
      if ($('.cg-woodivi-nav-item.has-dropdown.active').length > 0) {
        $('body').addClass('cg-woodivi-menu-active');
      } else {
        $('body').removeClass('cg-woodivi-menu-active');
      }
    });

    // Close dropdowns when clicking outside the menu wrapper
    $(document).on('click', function(e: any) {
      if (!$(e.target).closest('.cg-woodivi-megamenu-wrapper').length) {
        $('.cg-woodivi-nav-item.has-dropdown').removeClass('active');
        $('body').removeClass('cg-woodivi-menu-active');
      }
    });

    // Prevent clicks inside the dropdown panels from closing the menu
    $('.cg-woodivi-dropdown-panel').on('click', function(e: any) {
      e.stopPropagation();
    });

    // Hover handler for sidebar items to switch content panels
    $('.cg-woodivi-sidebar-item').on('mouseenter', function(this: HTMLElement) {
      const $item = $(this);
      const parentId = $item.data('id');
      const $container = $item.closest('.cg-woodivi-dropdown-container');
      
      // Switch active sidebar item
      $container.find('.cg-woodivi-sidebar-item').removeClass('active');
      $item.addClass('active');

      // Switch active content panel
      const $panels = $container.find('.cg-woodivi-content-panel');
      $panels.removeClass('active');
      $panels.filter('[data-id="' + parentId + '"]').addClass('active');
    });
  };

  // Initialize Mobile drawer and accordions
  const initMobileMegamenu = () => {
    const $trigger = $('.cg-woodivi-mobile-trigger');
    const $drawer  = $('.cg-woodivi-mobile-drawer');
    const $overlay = $('.cg-woodivi-mobile-overlay');
    const $close    = $('.cg-woodivi-mobile-close');

    // Open Drawer
    $trigger.on('click', function() {
      $drawer.addClass('active');
      $overlay.addClass('active');
      $('body').css('overflow', 'hidden'); // Prevent background scrolling
    });

    // Close Drawer
    const closeDrawer = () => {
      $drawer.removeClass('active');
      $overlay.removeClass('active');
      $('body').css('overflow', '');
    };

    $close.on('click', closeDrawer);
    $overlay.on('click', closeDrawer);

    // Mobile Level 1 Accordion
    $('.cg-woodivi-mobile-link.toggle-accordion').on('click', function(this: HTMLElement, e: any) {
      e.preventDefault();
      const $link = $(this);
      const $parent = $link.parent();
      const $content = $link.next('.cg-woodivi-mobile-accordion-content');

      $parent.toggleClass('open');
      $content.slideToggle(300);

      // Collapse others at level 1
      $('.cg-woodivi-mobile-item.has-accordion').not($parent).removeClass('open').find('.cg-woodivi-mobile-accordion-content').slideUp(300);
    });

    // Mobile Level 2 Accordion
    $('.toggle-sub-accordion').on('click', function(this: HTMLElement, e: any) {
      const $link = $(this);
      const $parent = $link.parent();
      const $content = $link.next('.cg-woodivi-mobile-sub-accordion-content');

      if ($content.length > 0) {
        e.preventDefault();
        $parent.toggleClass('open');
        $content.slideToggle(300);
        
        // Collapse other sub-accordions within the same panel
        $parent.siblings('.has-accordion').removeClass('open').find('.cg-woodivi-mobile-sub-accordion-content').slideUp(300);
      }
    });
  };

  initDesktopMegamenu();
  initMobileMegamenu();
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMegamenu);
} else {
  initMegamenu();
}
