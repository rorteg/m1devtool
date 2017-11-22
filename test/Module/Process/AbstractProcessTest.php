<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Process;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Module\Module;
use ROB\M1devtools\Module\Process\AbstractProcess;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class AbstractProcessTest extends TestCase
{
    /**
     * @var AbstractProcess
     */
    private $abstractProcessMock;

    const MODULE_TEST_NAME = 'ROB_Test';

    protected function setUp()
    {
        $moduleMock = $this->getMockBuilder(Module::class)->getMock();

        $this->abstractProcessMock = $this->getMockForAbstractClass(
            AbstractProcess::class,
            [$moduleMock]
        );
    }

    public function testGetModule()
    {
        $this->assertInstanceOf(Module::class, $this->abstractProcessMock->getModule());
    }

    public function testIfModuleStructureExists()
    {
        $module = new Module(self::MODULE_TEST_NAME);
        $module->setCodePool('local');

        $abstractModuck = $this->getMockForAbstractClass(
            AbstractProcess::class,
            [$module]
        );

        $directory = [
            $module->getModulePath()
        ];

        $virtualFs = vfsStream::setup('root', 777, $directory);

        //$this->assertTrue($abstractModuck->checkIfModuleStructureExists());
    }
}
