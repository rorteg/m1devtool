<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Process;

use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Module;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractProcess
{
    const MESSAGE_MODULE_EXISTS = 'The %s module already exists!';

    private $fs = false;

    /**
     * @var Module
     */
    private $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * @return Module
     * @codeCoverageIgnore
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return Filesystem
     * @codeCoverageIgnore
     */
    public function getFs()
    {
        if (! $this->fs) {
            $this->fs = new Filesystem();
        }

        return $this->fs;
    }

    /**
     * Check if the module structure exists
     * @return bool
     */
    public function checkIfModuleStructureExists()
    {
        return $this->getFs()->exists($this->getModule()->getModulePath());
    }

    /**
     * @param string $file
     * @return bool
     */
    public function checkIfFileExistsInModuleContext($file)
    {
        return $this->getFs()->exists($this->getModule()->getModulePath() . '/' . $file);
    }

    /**
     * @param string $target
     * @param string $location
     * @return bool
     */
    public function addInModman($target, $location)
    {
        if (! Config::getConfig('modman')) {
            return false;
        }

        $module = $this->getModule();

        if (! $this->getFs()->exists($module::MODMAN_FILE)) {
            $this->getFs()->dumpFile($module::MODMAN_FILE, '# ' . $module->getName() . PHP_EOL);
        }

        $this->getFs()->appendToFile(
            $module::MODMAN_FILE,
            $target . '    ' . $location . PHP_EOL
        );
    }
}
