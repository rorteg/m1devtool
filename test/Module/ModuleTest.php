<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Module\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    private $module;

    const MODULE_TEST_NAME = 'ROB_Test';
    const MODULE_TEST_VENDOR_NAME = 'ROB';
    const MODULE_TEST_MODULE_NAME = 'Test';

    protected function setUp()
    {
        $this->module = new Module();
    }

    public function testWhenNotSetCodePool()
    {
        $module = $this->module;
        $module->setName(self::MODULE_TEST_NAME);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            $this->translate(Module::MESSAGE_INVALID_CODEPOOL)
        );

        $module->getModulePath();
    }

    public function testWhenModuleNameIsInvalid()
    {
        $module = $this->module;
        $module->setName('ROB');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            $this->translate(Module::MESSAGE_INVALID_NAME)
        );

        $module->getName();
    }

    public function testReturnModulePath()
    {
        $module = $this->module;
        $module->setName(self::MODULE_TEST_NAME)
            ->setCodePool('local');

        $this->assertEquals($module->getModulePath(), 'app/code/local/ROB/Test');
    }

    /**
     * @dataProvider provideModuleFoldersId
     * @param string $pathId
     * @param string $expected
     */
    public function testReturnModulePathWithProvidePathId($pathId, $expected)
    {
        $module = $this->module;
        $module
            ->setName(self::MODULE_TEST_NAME)
            ->setCodePool('local');

        $this->assertEquals($module->getModulePath($pathId), $expected);
    }

    public function provideModuleFoldersId()
    {
        $modulePath = 'app/code/local/' . self::MODULE_TEST_VENDOR_NAME . '/' . self::MODULE_TEST_MODULE_NAME . '/';
        return [
            [Module::MODULE_PATH_ID_BLOCK, $modulePath . 'Block'],
            [Module::MODULE_PATH_ID_ETC, $modulePath . 'etc'],
            [Module::MODULE_PATH_ID_HELPER, $modulePath . 'Helper'],
            [Module::MODULE_PATH_ID_CONTROLLER, $modulePath . 'controllers'],
            [Module::MODULE_PATH_ID_DATA, $modulePath . 'data'],
            [Module::MODULE_PATH_ID_SQL, $modulePath . 'sql'],
            [Module::MODULE_PATH_ID_MAGE_ETC_MODULES, 'app/etc/modules'],
        ];
    }

    public function testGetModuleBasicStructure()
    {
        $module = $this->module;
        $module->setCodePool('local');
        $module->setName(self::MODULE_TEST_NAME);

        $this->assertArraySubset($module->getModuleBasicStructure(), [
            $module->getModulePath($module::MODULE_PATH_ID_ETC),
            $module->getModulePath($module::MODULE_PATH_ID_HELPER)
        ]);
    }

    public function testGetModuleAliasAndCodePool()
    {
        $module = $this->module;
        $module->setName('ROB_Test');
        $module->setCodePool('local');

        $this->assertEquals($module->getCodePool(), 'local');
        $this->assertEquals($module->getModuleAlias(), 'rob_test');
    }

    private function translate($message)
    {
        $translator = Config::getTranslator();
        return $translator->translate($message);
    }
}
