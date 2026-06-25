import {
  type Metadata,
  type ModuleLibrary,
} from '@divi/types';

import metadata from './module.json';
import defaultRenderAttributes from './module-default-render-attributes.json';
import defaultPrintedStyleAttributes from './module-default-printed-style-attributes.json';
import { CGWooDiviMegamenuEdit } from './edit';
import { CGWooDiviMegamenuAttrs } from './types';

import './module.scss';

export const cgWooDiviMegamenu: ModuleLibrary.Module.RegisterDefinition<CGWooDiviMegamenuAttrs> = {
  metadata:                 metadata as Metadata.Values<CGWooDiviMegamenuAttrs>,
  defaultAttrs:             defaultRenderAttributes as Metadata.DefaultAttributes<CGWooDiviMegamenuAttrs>,
  defaultPrintedStyleAttrs: defaultPrintedStyleAttributes as Metadata.DefaultAttributes<CGWooDiviMegamenuAttrs>,
  renderers: {
    edit: CGWooDiviMegamenuEdit,
  },
};
export { CGWooDiviMegamenuEdit };
export type { CGWooDiviMegamenuAttrs };
export default cgWooDiviMegamenu;
