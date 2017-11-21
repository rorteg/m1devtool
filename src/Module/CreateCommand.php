<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateCommand extends Command
{
    const HELP = <<< 'EOT'
Create a new module for the Magento 1.
- Creates an appropriate module structure containing a source code tree and Settings.
EOT;

    const HELP_ARG_MODULE = 'The module to create.';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Module|null
     */
    protected $moduleInstance = null;

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this->setDescription('Create new Magento 1 module');
        $this->setHelp(self::HELP);
        CommandCommonOptions::addDefaultOptionsAndArguments($this);
        $this->config = new Config();
    }

    /**
     * Executes command by creating new module.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument('name');
        $codePool = $input->getOption('code-pool');
        $helper = $this->getHelper('question');
        $translator = Config::getTranslator();

        if (! $moduleName) {
            $question = new Question(
                '<question>' .
                $translator->translate('Please enter the name of the Module (Vendor_Module):') .
                '</question> '
            );

            $question->setValidator(function ($answer) {
                return $this->getModuleInstance($answer)->validateName();
            });

            $question->setMaxAttempts(3);
            $module = $this->getModuleInstance(
                $helper->ask($input, $output, $question)
            );
        } else {
            $module = $this->getModuleInstance($moduleName);
            $module->validateName();
        }

        $module->setCodePool($codePool);

        $output->writeln('Module Name: ' . $module->getName() . PHP_EOL . 'Code Pool: ' . $module->getCodePool());
        $output->writeln($module->runProcess(Process\CreateFirstStructure::class));
    }

    /**
     * @param string $name
     * @return null|Module
     */
    protected function getModuleInstance($name = '')
    {
        if ($this->moduleInstance === null) {
            $this->moduleInstance = new Module($name);
        } else {
            $this->moduleInstance->setName($name);
        }

        return $this->moduleInstance;
    }
}
