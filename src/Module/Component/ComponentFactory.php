<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

use ROB\M1devtools\Filesystem\FilesystemInterface;
use ROB\M1devtools\Module\Component\Exception\RuntimeException;
use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\ModuleFacadeInterface;

class ComponentFactory
{
    /**
     * @var ModuleFacadeInterface
     */
    private $moduleFacade;

    /**
     * @var FilesystemInterface
     */
    private $fs;

    /**
     * ComponentFactory constructor.
     * @param ModuleFacadeInterface $moduleFacade
     * @param FilesystemInterface $fs
     */
    public function __construct(
        ModuleFacadeInterface $moduleFacade = null,
        FilesystemInterface $fs
    ) {

        $this->moduleFacade = $moduleFacade;
        $this->fs = $fs;
    }

    /**
     * @param ModuleFacadeInterface $moduleFacade
     * @codeCoverageIgnore
     */
    public function setModuleFacade(ModuleFacadeInterface $moduleFacade)
    {
        $this->moduleFacade = $moduleFacade;
    }

    /**
     * @param string $componentName Ex: mage_register_file creates MageRegisterFile Object
     * @return mixed
     */
    public function __invoke($componentName)
    {
        $className = 'ROB\\M1devtools\\Module\\Component\\' .
            preg_replace('/\s+/', '', ucwords(str_replace('_', ' ', $componentName)));

        if (! class_exists($className)) {
            throw new RuntimeException(sprintf('Class %s does not exist', $className));
        }

        return new $className($this->moduleFacade, $this->fs);
    }
}
