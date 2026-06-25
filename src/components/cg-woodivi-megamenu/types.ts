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
  navbar?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow'
    >;
  };
  navLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'font'
    >;
  };
  dropdownPanel?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow'
    >;
  };
  sidebar?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing'
    >;
  };
  sidebarLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'font'
    >;
  };
  contentPanel?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing'
    >;
  };
  sublistLinks?: {
    decoration?: Element.Decoration.PickedAttributes<
      'font'
    >;
  };
  ctaButton?: {
    decoration?: Element.Decoration.PickedAttributes<
      'background' | 'border' | 'spacing' | 'boxShadow' | 'font'
    >;
  };
}

export type CGWooDiviMegamenuEditProps = ModuleEditProps<CGWooDiviMegamenuAttrs>;
