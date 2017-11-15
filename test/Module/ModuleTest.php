<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Module\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    private $module;

    protected function setUp()
    {
        $this->module = new Module();
    }

    public function testWhenNotSetCodePool()
    {
        $module = $this->module;
        $module->setName('ROB_Test');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(Module::MESSAGE_INVALID_CODEPOOL);

        $module->getModulePath();
    }

    public function testWhenModuleNamsIsInvalid()
    {
        $module = $this->module;
        $module->setName('ROB');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(Module::MESSAGE_INVALID_NAME);

        $module->getName();
    }

    public function testReturnModulePath()
    {
        $module = $this->module;
        $module->setName('ROB_Test')
            ->setCodePool('local');

        $this->assertEquals($module->getModulePath(), 'app/code/local/ROB/Test');
    }
}
