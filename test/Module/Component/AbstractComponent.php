<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Filesystem\FilesystemAdapter;
use ROB\M1devtools\Module\Component\ComponentFactory;
use ROB\M1devtools\Module\Component\ComponentInterface;
use ROB\M1devtools\Module\ModuleFacadeFactory;
use ROB\M1devtools\Module\ModuleFacade;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class AbstractComponent extends TestCase
{
    /**
     * @var ComponentFactory
     */
    protected $componentFactory;

    /**
     * @var ModuleFacade
     */
    protected $moduleFacade;

    /**
     * @var ComponentInterface
     */
    protected $componentContext;

    protected function setUp()
    {
        $moduleFactory = new ModuleFacadeFactory;
        $this->moduleFacade = $moduleFactory('ROB_Test');
        $fs = new FilesystemAdapter();
        $this->componentFactory = new ComponentFactory($this->moduleFacade, $fs);
    }

    protected function createModule()
    {
        if (! $this->moduleFacade->exists()) {
            $this->moduleFacade->create();
        }
    }

    protected function removeModule()
    {
        if ($this->moduleFacade->exists()) {
            $this->moduleFacade->remove();
        }
    }

    protected function tearDown()
    {
        $this->removeModule();
    }
}
