<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
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
        $helper = $this->getHelper('question');

        if (! $moduleName) {
            $question = new Question('<question>Please enter the name of the Module (Vendor_Module): </question>');

            $question->setValidator(function ($answer) {
                $this->validateModuleName($answer);
            });

            $question->setMaxAttempts(3);
            $moduleName = $helper->ask($input, $output, $question);
        } else {
            $this->validateModuleName($moduleName);
        }

        $output->writeln(sprintf('<info>%s</info>', $moduleName));
    }

    private function validateModuleName($moduleName)
    {
        $moduleNameExplode = explode('_', $moduleName);
        if (! substr_count($moduleName, '_')
            || count($moduleNameExplode) !== 2
            || ($moduleNameExplode[1] == '')) {
            throw new RuntimeException('The module name needs to follow the following format: Vendor_Module');
        }

        return $moduleName;
    }
}
