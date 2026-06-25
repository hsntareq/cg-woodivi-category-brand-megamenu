import { ModuleClassnamesParams } from '@divi/module';
import { CGWooDiviMegamenuAttrs } from './types';

export const moduleClassnames = ({
  classnamesInstance,
}: ModuleClassnamesParams<CGWooDiviMegamenuAttrs>): void => {
  classnamesInstance.add('cg-woodivi-megamenu');
};
