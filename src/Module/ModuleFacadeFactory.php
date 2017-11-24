<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Filesystem\FilesystemAdapter;

class ModuleFacadeFactory
{
    public function __invoke($moduleName, $codePool = 'local')
    {
        $module = new Module($moduleName, $codePool);
        $fileSystem = new FilesystemAdapter();
        return new ModuleFacade($module, $fileSystem);
    }
}
