<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Process;

use ROB\M1devtools\Module\Module;
use Symfony\Component\Filesystem\Filesystem;
use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Config;

abstract class AbstractProcess
{
    const MESSAGE_MODULE_EXISTS = 'The %s module already exists!';

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
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return Filesystem
     */
    public function getFs()
    {
        return new Filesystem();
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
}
