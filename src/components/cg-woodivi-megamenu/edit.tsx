import React, { ReactElement } from 'react';
import { ModuleContainer } from '@divi/module';
import { CGWooDiviMegamenuEditProps } from './types';
import { ModuleStyles } from './styles';
import { ModuleScriptData } from './module-script-data';
import { moduleClassnames } from './module-classnames';

export const CGWooDiviMegamenuEdit = (props: CGWooDiviMegamenuEditProps): ReactElement => {
  const {
    attrs,
    elements,
    id,
    name,
  } = props;

  return (
    <ModuleContainer
      attrs={attrs}
      elements={elements}
      id={id}
      name={name}
      stylesComponent={ModuleStyles}
      classnamesFunction={moduleClassnames}
      scriptDataComponent={ModuleScriptData}
    >
      {elements.styleComponents({
        attrName: 'module',
      })}
      {elements.styleComponents({
        attrName: 'mainMenuBar',
      })}
      {elements.styleComponents({
        attrName: 'mainMenuBarLinks',
      })}
      {elements.styleComponents({
        attrName: 'megamenuDropdownPanel',
      })}
      {elements.styleComponents({
        attrName: 'dropdownLeftSidebar',
      })}
      {elements.styleComponents({
        attrName: 'dropdownSidebarLinks',
      })}
      {elements.styleComponents({
        attrName: 'desktopRightGridPanel',
      })}
      {elements.styleComponents({
        attrName: 'dropdownSubmenuLinks',
      })}
      {elements.styleComponents({
        attrName: 'dropdownCtaButtons',
      })}
      
      <div 
        className="cg-woodivi-megamenu-vb-placeholder"
        style={{
          width: 'auto',
          fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
          backgroundColor: '#1c2b39',
          color: '#ffffff',
          display: 'inline-flex',
          alignItems: 'center',
          padding: '0 15px',
          height: '50px',
          boxSizing: 'border-box',
          borderRadius: '4px',
          boxShadow: '0 2px 5px rgba(0,0,0,0.1)',
        }}
      >
        <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
          <div style={{ fontSize: '13px', fontWeight: 700, letterSpacing: '0.5px', textTransform: 'uppercase', color: '#ff9c00', cursor: 'default' }}>
            SHOP BY CATEGORY <span style={{ fontSize: '10px', marginLeft: '5px' }}>▼</span>
          </div>
          <div style={{ fontSize: '13px', fontWeight: 700, letterSpacing: '0.5px', textTransform: 'uppercase', color: '#ffffff', cursor: 'default' }}>
            SHOP BY BRAND <span style={{ fontSize: '10px', marginLeft: '5px' }}>▶</span>
          </div>
          <div style={{ fontSize: '11px', color: '#8b9da9', fontStyle: 'italic', marginLeft: '10px' }}>
            (Visual Builder Preview Mode)
          </div>
        </div>
      </div>
    </ModuleContainer>
  );
};
