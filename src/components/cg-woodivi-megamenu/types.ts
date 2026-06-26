import { ModuleEditProps } from '@divi/module-library';
import {
  FormatBreakpointStateAttr,
  InternalAttrs,
  type Element,
  type Module,
} from '@divi/types';

export interface CGWooDiviMegamenuCssAttr extends Module.Css.AttributeValue {
  mainElement?: string;
}

export type CGWooDiviMegamenuCssGroupAttr = FormatBreakpointStateAttr<CGWooDiviMegamenuCssAttr>;

export interface CGWooDiviMegamenuAttrs extends InternalAttrs {
  css?: CGWooDiviMegamenuCssGroupAttr;
  module?: {
    meta?: Element.Meta.Attributes;
    advanced?: {
      link?: Element.Advanced.Link.Attributes;
      htmlAttributes?: Element.Advanced.IdClasses.Attributes;
    };
    decoration?: Element.Decoration.PickedAttributes<
      'background' |
      'border' |
      'boxShadow' |
      'disabledOn' |
      'filters' |
      'overflow' |
      'position' |
      'scroll' |
      'sizing' |
      'spacing' |
      'sticky' |
      'transform' |
      'transition' |
      'zIndex'
    >;
  };
  mainMenuBar?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow'
    >;
  };
  mainMenuBarLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'font'
    >;
  };
  megamenuDropdownPanel?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow'
    >;
  };
  dropdownLeftSidebar?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing'
    >;
  };
  dropdownSidebarLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'font'
    >;
  };
  desktopRightGridPanel?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing'
    >;
  };
  dropdownSubmenuLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'font'
    >;
  };
  dropdownCtaButtons?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow' | 'font'
    >;
  };
}

export type CGWooDiviMegamenuEditProps = ModuleEditProps<CGWooDiviMegamenuAttrs>;
