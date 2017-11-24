<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ConfigCommand extends Command
{
    const HELP = 'Generates a configuration json file (m1devtools.json)';

    protected function configure()
    {
        $this->setDescription(self::HELP);
        $this->setHelp(self::HELP);
    }

    /**
     * Executes command by creating settings file.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = new Config();
        $fs = new Filesystem();
        $fs->dumpFile($config::CONFIG_FILE_NAME, json_encode($config->getDefaults(), JSON_PRETTY_PRINT));

        $output->writeln(
            '<info>' .
            $config::getTranslator()->translate('Configuration file created successfully!') .
            '</info>'
        );
    }
}
