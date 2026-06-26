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
      if (window.innerWidth <= 980) {
        // Reset/collapse accordion items when transitioning to mobile
        $('.cg-woodivi-sidebar-item').removeClass('active');
        $('.cg-woodivi-mobile-inline-sublist').hide();
      } else {
        // Restore first item as active on desktop if none are active
        $('.cg-woodivi-dropdown-container').each(function() {
          const $container = $(this);
          if (!$container.find('.cg-woodivi-sidebar-item.active').length) {
            const $firstItem = $container.find('.cg-woodivi-sidebar-item').first();
            $firstItem.addClass('active');
            const parentId = $firstItem.data('id');
            $container.find('.cg-woodivi-content-panel').removeClass('active');
            $container.find('.cg-woodivi-content-panel[data-id="' + parentId + '"]').addClass('active');
          }
        });
      }

      $('.cg-woodivi-nav-item.has-dropdown.active').each(function(this: HTMLElement) {
        positionDropdown($(this));
      });
    });

    // Hover or click handler for sidebar items
    $('.cg-woodivi-sidebar-item').on('mouseenter click', function(this: HTMLElement, e: any) {
      const isMobile = window.innerWidth <= 980;

      if (isMobile) {
        if (e.type === 'mouseenter') {
          return; // Ignore hover/mouseenter events on mobile
        }
        e.preventDefault();
        e.stopPropagation();

        const $item = $(this);
        const $sublist = $item.find('.cg-woodivi-mobile-inline-sublist');
        const $sidebar = $item.closest('.cg-woodivi-sidebar');

        if ($item.hasClass('active')) {
          $sublist.slideUp(300);
          $item.removeClass('active');
        } else {
          // Collapse other active accordion items in the same sidebar
          $sidebar.find('.cg-woodivi-sidebar-item.active').each(function() {
            const $otherItem = $(this);
            $otherItem.removeClass('active');
            $otherItem.find('.cg-woodivi-mobile-inline-sublist').slideUp(300);
          });

          // Expand clicked accordion item
          $item.addClass('active');
          $sublist.slideDown(300);
        }
      } else {
        // Desktop behavior
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
      }
    });
  };

  initDesktopMegamenu();

  // Collapse accordions on initial page load if viewport is mobile
  if (window.innerWidth <= 980) {
    $('.cg-woodivi-sidebar-item').removeClass('active');
    $('.cg-woodivi-mobile-inline-sublist').hide();
  }
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMegamenu);
} else {
  initMegamenu();
}
