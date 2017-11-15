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
use Symfony\Component\Console\Tester\CommandTester;

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

    /**
     * @var string
     */
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
     * @todo test
     * @dataProvider            provideErrorModuleNameForQuestionInputs
     * @expectedException       RuntimeException
     */
    public function testRunWithoutModuleNameArgument($moduleName)
    {
        $symfonyConsoleVersion = $this->getPackageComposerVersion('symfony/console');

        $commandTester = new CommandTester($this->createCommand);

        if (version_compare($symfonyConsoleVersion, '3.2', '<')) {
            $helper = $this->createCommand->getHelper('question');
            $helper->setInputStream($this->getInputStream($moduleName));
        } else {
            $commandTester->setInputs([$moduleName]);
        }

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

    public function provideErrorModuleNameForQuestionInputs()
    {
        return [
            ['rob', 'ROB_', 'ROB_Test', '']
        ];
    }

    public function provideErrorModuleNames()
    {
        return [
            ['Rob'],
            ['Rob_'],
            ['rob'],
            ['robTest']
        ];
    }

    private function getPackageComposerVersion($packageName)
    {
        $data = [];
        $packages = json_decode(file_get_contents(__DIR__ . '/../../vendor/composer/installed.json'), true);


        foreach ($packages as $package) {
            $data[$package['name']] = $package['version'];
        }

        return $data[$packageName];
    }

    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
