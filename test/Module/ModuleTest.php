<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Module\Exception\InvalidArgumentException;
use ROB\M1devtools\Module\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        $this->module = new Module('ROB_Test');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The module name is a required parameter
     */
    public function testWithoutArgumentsInConstructor()
    {
        $module = new Module();
    }

    /**
     * @dataProvider provideInvalidArgumentsToConstructor
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The module name needs to follow the following format: Vendor_Module
     */
    public function testInvalidArgumentsInConstructor($fullName)
    {
        $module = new Module($fullName);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Code Pool
     */
    public function testInvalidCodePoolInConstructor()
    {
        $module = new Module('ROB_Test', 'test');
    }

    public function provideInvalidArgumentsToConstructor()
    {
        return [
            ['rob'],
            ['ROB'],
            ['ookokds-okokds']
        ];
    }

    public function testModuleFullNameReturn()
    {
        $this->assertEquals('ROB_Test', $this->module->getFullName());
    }

    public function testModuleNameReturn()
    {
        $this->assertEquals('Test', $this->module->getName());
    }

    public function testModuleVendorReturn()
    {
        $this->assertEquals('ROB', $this->module->getVendor());
    }

    public function testCodePoolReturn()
    {
        $this->assertEquals('local', $this->module->getCodePool());

        $module = new Module('ROB_Test', 'community');
        $this->assertEquals('community', $module->getCodePool());
    }

    public function testPathReturn()
    {
        $this->assertEquals('app/code/local/ROB/Test', $this->module->getPath());
    }

    public function testAliasReturn()
    {
        $this->assertEquals('rob_test', $this->module->getAlias());
    }

    public function testDefaultVersion()
    {
        $this->assertEquals('0.1.0', $this->module->getVersion());
    }

    public function testSetVersion()
    {
        $this->module->setVersion('1.0.0');
        $this->assertEquals('1.0.0', $this->module->getVersion());
    }

    public function testMageRegisterFileRelativePathReturn()
    {
        $this->assertEquals('app/etc/modules/ROB_Test.xml', $this->module->getMageRegistryFile());
    }
}
