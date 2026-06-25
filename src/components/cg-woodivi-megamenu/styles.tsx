import React, { ReactElement } from 'react';
import {
  StyleContainer,
  StylesProps,
  CssStyle,
} from '@divi/module';

import { CGWooDiviMegamenuAttrs } from './types';
import { cssFields } from './custom-css';

export const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}: StylesProps<CGWooDiviMegamenuAttrs>): ReactElement => {
  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      {elements.style({
        attrName: 'module',
        styleProps: {
          disabledOn: {
            disabledModuleVisibility: settings?.disabledModuleVisibility,
          },
        },
      })}

      {elements.style({
        attrName: 'navbar',
      })}

      {elements.style({
        attrName: 'navLinks',
      })}

      {elements.style({
        attrName: 'dropdownPanel',
      })}

      {elements.style({
        attrName: 'sidebar',
      })}

      {elements.style({
        attrName: 'sidebarLinks',
      })}

      {elements.style({
        attrName: 'contentPanel',
      })}

      {elements.style({
        attrName: 'sublistLinks',
      })}

      {elements.style({
        attrName: 'ctaButton',
      })}

      <CssStyle
        selector={orderClass}
        attr={attrs.css}
        cssFields={cssFields}
      />
    </StyleContainer>
  );
};
