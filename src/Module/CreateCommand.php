<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Module\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{
    const HELP = <<< 'EOT'
Create a new module for the Magento 1.
- Creates an appropriate module structure containing a source code tree and Settings.
EOT;

    const HELP_ARG_MODULE = 'The module to create.';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this->setDescription('Create new Magento 1 module');
        $this->setHelp(self::HELP);
        CommandCommonOptions::addDefaultOptionsAndArguments($this);
    }

    /**
     * Execute command
     *
     * Executes command by creating new module tree, and then executing
     * the "register" command with the same module name.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument('name');
        $moduleNameExplode = explode('_', $moduleName);
        if (! substr_count($moduleName, '_')
            || count($moduleNameExplode) !== 2
            || ($moduleNameExplode[1] == '')) {
            throw new RuntimeException('The module name needs to follow the following format: Vendor_Module');
        }


        $output->writeln(sprintf('<info>%s</info>', var_dump(explode('_', $moduleName))));
    }
}
