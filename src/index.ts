import { omit } from 'lodash';
import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { cgWooDiviMegamenu } from './components/cg-woodivi-megamenu';

// Register modules.
const registerModules = () => {
  registerModule(cgWooDiviMegamenu.metadata, omit(cgWooDiviMegamenu, 'metadata'));
};

addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'cgWooDiviMegamenu', registerModules);

// Fallback in case the hook has already fired when this bundle loads
if (typeof window !== 'undefined' && window.divi?.moduleLibrary?.registerModule) {
  registerModules();
}
