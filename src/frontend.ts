import './components/cg-woodivi-megamenu/module.scss';

const initMegamenu = () => {
  const $ = (window as any).jQuery;
  if (!$) return;

  const positionDropdown = ($item: any) => {
    const $panel = $item.find('.cg-woodivi-dropdown-panel');
    if (!$panel.length) return;

    if (window.innerWidth <= 980) {
      // Reset layout positioning on mobile to let CSS handle inline accordion flow
      $panel.css({
        width: '',
        left: ''
      });
      return;
    }

    const $wrapper = $item.closest('.cg-woodivi-megamenu-wrapper');
    if (!$wrapper.length) return;

    let $target = $wrapper.closest('.et_pb_row');
    if (!$target.length) {
      $target = $wrapper.closest('.et_pb_column');
    }
    if (!$target.length) {
      $target = $wrapper.closest('.et_pb_section');
    }

    if ($target.length) {
      const targetWidth = $target.outerWidth();
      const targetLeft = $target.offset().left;
      const wrapperLeft = $wrapper.offset().left;
      const offsetLeft = targetLeft - wrapperLeft;

      $panel.css({
        width: `${targetWidth}px`,
        left: `${offsetLeft}px`
      });
    } else {
      $panel.css({
        width: `${$wrapper.outerWidth()}px`,
        left: '0px'
      });
    }
  };

  const initDesktopMegamenu = () => {
    // Click handler for main navigation dropdowns (both desktop and mobile)
    $('.cg-woodivi-nav-item.has-dropdown > .cg-woodivi-nav-link').on('click', function(this: HTMLElement, e: any) {
      e.preventDefault();
      e.stopPropagation();
      
      const $item = $(this).parent('.cg-woodivi-nav-item');
      
      // Deactivate other dropdowns
      $('.cg-woodivi-nav-item.has-dropdown').not($item).removeClass('active');
      
      // Toggle active class on clicked dropdown
      $item.toggleClass('active');

      if ($item.hasClass('active')) {
        positionDropdown($item);
      }

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

    // Position active dropdowns on window resize
    $(window).on('resize', function() {
      $('.cg-woodivi-nav-item.has-dropdown.active').each(function(this: HTMLElement) {
        positionDropdown($(this));
      });
    });

    // Hover or click handler for sidebar items (works for mouseover on desktop and click/tap on touch devices)
    $('.cg-woodivi-sidebar-item').on('mouseenter click', function(this: HTMLElement, e: any) {
      if (e.type === 'click') {
        e.preventDefault();
        e.stopPropagation();
      }

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

  initDesktopMegamenu();
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMegamenu);
} else {
  initMegamenu();
}
