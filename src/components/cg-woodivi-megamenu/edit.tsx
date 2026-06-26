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
      
      <div className="cg-woodivi-megamenu-wrapper">
        <nav className="cg-woodivi-navbar">
          <ul className="cg-woodivi-nav-list">
            <li className="cg-woodivi-nav-item has-dropdown">
              <a href="#" className="cg-woodivi-nav-link" onClick={(e) => e.preventDefault()}>
                SHOP BY CATEGORY <span className="cg-arrow cg-arrow-down">&#9662;</span>
              </a>
            </li>
            <li className="cg-woodivi-nav-item has-dropdown">
              <a href="#" className="cg-woodivi-nav-link" onClick={(e) => e.preventDefault()}>
                SHOP BY BRAND <span className="cg-arrow cg-arrow-right">&#9656;</span>
              </a>
            </li>
            <li className="cg-woodivi-nav-item" style={{ display: 'inline-flex', alignItems: 'center', marginLeft: '20px', height: '100%' }}>
              <span style={{ fontSize: '11px', color: '#8b9da9', fontStyle: 'italic', opacity: 0.7, textTransform: 'none', cursor: 'default' }}>
                (Visual Builder Preview Mode)
              </span>
            </li>
          </ul>
        </nav>
      </div>
    </ModuleContainer>
  );
};
