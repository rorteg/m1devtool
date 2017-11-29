<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Filesystem\FilesystemAdapter;
use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Module\Module;
use ROB\M1devtools\Module\ModuleFacade;
use Noodlehaus\Config as NoodlehausConfig;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ModuleFacadeTest extends TestCase
{
    /**
     * @var ModuleFacade
     */
    private $moduleFacade;

    protected function setUp()
    {
        $module = new Module('ROB_Test');
        $fs = new FilesystemAdapter();

        $this->moduleFacade = new ModuleFacade(
            $module,
            $fs
        );
    }

    public function testCreateModule()
    {
        $this->assertInstanceOf(ModuleFacade::class, $this->moduleFacade->create());
    }

    /**
     * @depends testCreateModule
     */
    public function testCreateModuleIfExists()
    {
        $moduleFacade = $this->moduleFacade;
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($moduleFacade::MESSAGE_MODULE_EXISTS);

        $moduleFacade->create();
    }

    /**
     * @depends testCreateModuleIfExists
     */
    public function testRemoveModule()
    {
        $this->assertTrue($this->moduleFacade->remove());
    }

    /**
     * @depends testRemoveModule
     */
    public function testModuleNotExists()
    {
        $this->assertInstanceOf(Module::class, $this->moduleFacade->getModule());
        $this->assertFalse($this->moduleFacade->exists());

        // Remove path app if run tests MiDevTools
        $fs = new FilesystemAdapter();
        if ($fs->exists('composer.json')) {
            $composerConfig = new NoodlehausConfig('composer.json');

            if ($composerConfig->get('name') == 'rorteg/m1devtools') {
                $fs->remove('app');
            }
        }
    }

    /**
     * @depends testModuleNotExists
     */
    public function testRemoveModuleIfNotExists()
    {
        $moduleFacade = $this->moduleFacade;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($moduleFacade::MESSAGE_MODULE_NOT_EXISTS);

        $moduleFacade->remove();
    }
}
