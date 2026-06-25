import React, {
  Fragment,
  ReactElement,
} from 'react';

import {
  ModuleScriptDataProps,
} from '@divi/module';
import { CGWooDiviMegamenuAttrs } from './types';

export const ModuleScriptData = ({
  elements,
}: ModuleScriptDataProps<CGWooDiviMegamenuAttrs>): ReactElement => (
  <Fragment>
    {elements.scriptData({
      attrName: 'module',
    })}
  </Fragment>
);
