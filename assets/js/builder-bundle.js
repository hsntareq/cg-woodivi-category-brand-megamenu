/**
 * Divi 5 Visual Builder Script for CG WooDivi Megamenu
 * Registers the React block component for edit mode.
 */
(function() {
  'use strict';

  var addAction = window.wp.hooks.addAction;
  var registerModule = window.divi.moduleLibrary.registerModule;
  var React = window.vendor.React;
  var ModuleContainer = window.divi.module.ModuleContainer;

  // 1. Define the Edit React Component
  function MegamenuEdit(props) {
    var attrs = props.attrs;
    var elements = props.elements;
    var id = props.id;
    var name = props.name;

    // Render a premium placeholder block in visual editor mode
    return React.createElement(
      ModuleContainer,
      {
        attrs: attrs,
        elements: elements,
        id: id,
        name: name
      },
      React.createElement(
        'div',
        {
          className: 'cg-woodivi-megamenu-builder-placeholder',
          style: {
            padding: '40px 20px',
            background: '#1c2b39',
            color: '#ffffff',
            border: '2px dashed #ff9c00',
            borderRadius: '4px',
            textAlign: 'center',
            fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
            boxShadow: '0 4px 15px rgba(0,0,0,0.1)'
          }
        },
        React.createElement('h3', { 
          style: { 
            margin: '0 0 10px 0', 
            color: '#ff9c00',
            fontSize: '18px',
            fontWeight: '700',
            letterSpacing: '0.5px',
            textTransform: 'uppercase'
          } 
        }, 'CG WooDivi Megamenu'),
        React.createElement('p', { 
          style: { 
            margin: 0, 
            fontSize: '13px', 
            opacity: 0.8,
            lineHeight: '1.5'
          } 
        }, 'This module displays the premium category & brand megamenu. Interactive dropdown features are active on the frontend view.')
      )
    );
  }

  // 2. Define the module metadata (should match module.json exactly)
  var metadata = {
    "name": "cg-woodivi-megamenu/cg-woodivi-megamenu",
    "d4Shortcode": "et_pb_cg_woodivi_megamenu",
    "title": "CG WooDivi Megamenu",
    "moduleIcon": "divi/module-menu",
    "category": "module",
    "attributes": {
      "module": {
        "type": "object",
        "selector": "{{selector}}",
        "settings": {
          "advanced": {},
          "decoration": {}
        }
      }
    },
    "settings": {
      "content": "auto",
      "design": "auto",
      "advanced": "auto"
    }
  };

  // 3. Define the registration function
  function register() {
    if (typeof registerModule === 'function') {
      registerModule(metadata, {
        renderers: {
          edit: MegamenuEdit
        }
      });
    }
  }

  // 4. Hook it into the Divi 5 Visual Builder store hook
  addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'cgWooDiviMegamenu', register);

  // Fallback if hook already fired
  if (typeof window !== 'undefined' && window.divi && window.divi.moduleLibrary && window.divi.moduleLibrary.registerModule) {
    register();
  }
})();
