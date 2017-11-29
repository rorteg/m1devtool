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
use ROB\M1devtools\Module\Component\Exception\RuntimeException;
use ROB\M1devtools\Module\Component\MageRegisterFile;
use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\ModuleFacadeFactory;

class ComponentFactoryTest extends TestCase
{
    /**
     * @var ComponentFactory
     */
    private $componentFactory;

    protected function setUp()
    {
        $moduleFactory = new ModuleFacadeFactory;
        $moduleFacade = $moduleFactory('ROB_Test');
        $fs = $this->getMockBuilder(FilesystemAdapter::class)->getMock();
        $this->componentFactory = new ComponentFactory($moduleFacade, $fs);
    }

    public function testCreateComponent()
    {
        $componentFactory = $this->componentFactory;
        $this->assertInstanceOf(MageRegisterFile::class, $componentFactory('mage_register_file'));
    }

    /**
     * @dataProvider provideInvalidArgumentForCreateComponent
     * @expectedException \Exception
     * @param $componentName
     */
    public function testCreateComponentWithInvalidArgument($componentName)
    {
        $componentFactory = $this->componentFactory;
        $componentFactory($componentName);
    }

    public function provideInvalidArgumentForCreateComponent()
    {
        return [
            ['test'],
            ['']
        ];
    }
}
