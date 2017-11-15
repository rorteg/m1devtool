<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CommandCommonOptions
 * @internal
 */
final class CommandCommonOptions
{
    /**
     * Add default arguments and options used by all commands.
     * @param Command $command
     */
    public static function addDefaultOptionsAndArguments(Command $command)
    {
        $command->addArgument(
            'name',
            InputArgument::OPTIONAL,
            'Specify the module vendor name. Ex: Vendor_Module'
        );

        $command->addOption(
            'code-pool',
            'cp',
            InputOption::VALUE_REQUIRED,
            'Specify the code pool. Ex: "community"',
            'local'
        );
    }
}
