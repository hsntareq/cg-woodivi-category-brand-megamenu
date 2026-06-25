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
}

export type CGWooDiviMegamenuEditProps = ModuleEditProps<CGWooDiviMegamenuAttrs>;
