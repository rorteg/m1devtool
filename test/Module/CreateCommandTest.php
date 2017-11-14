<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use ROB\M1devtools\Module\CreateCommand;
use ROB\M1devtools\Module\Exception\RuntimeException;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class CreateCommandTest extends TestCase
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var ApplicationTester
     */
    protected $applicationTester;

    protected $commandAlias = 'module:create';

    /**
     * @var CreateCommand
     */
    protected $createCommand;

    protected function setUp()
    {
        $this->application = new Application();
        $this->createCommand = new CreateCommand($this->commandAlias);
        $this->application->addCommands([
            $this->createCommand
        ]);
        $this->application->setAutoExit(false);
        $this->application->setCatchExceptions(false);
        $this->applicationTester = new ApplicationTester($this->application);
    }

    /**
     * @expectedException        RuntimeException
     */
    public function testRunWithoutModuleNameArgument()
    {
        $this->applicationTester->run(['command' => $this->commandAlias]);
    }

    /**
     * @expectedException        RuntimeException
     * @dataProvider             provideErrorModuleNames
     */
    public function testRunWithRuntimeExceptionWhenModuleNameIsIncorrectFormat($moduleName)
    {
        $this->applicationTester->run(['command' => $this->commandAlias, 'name' => $moduleName]);
    }

    public function provideErrorModuleNames()
    {
        return [
            ['Rob'],
            ['Rob_'],
            ['']
        ];
    }
}
