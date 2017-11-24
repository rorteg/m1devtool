<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use Mockery\CountValidator\Exception;
use ROB\M1devtools\Module\Component\ComponentFactory;
use ROB\M1devtools\Module\Component\ComponentInterface;
use ROB\M1devtools\Module\Exception\RuntimeException as ModuleRuntimeException;
use Symfony\Component\Filesystem\Filesystem;

class ModuleFacade implements ModuleFacadeInterface
{
    const MESSAGE_MODULE_NOT_EXISTS = 'Module not exists';
    const MESSAGE_MODULE_EXISTS = 'Module already exists';
    const COMPONENT_MAGE_REGISTER_FILE = 'mage_register_file';
    const COMPONENT_HELPER = 'helper';
    const COMPONENT_CONFIG = 'config';

    /**
     * @var Module
     */
    private $module;

    /**
     * @var Filesystem
     */
    private $filesystem;

    protected $components = [];

    /**
     * ModuleFacade constructor.
     * @param Module $module
     * @param Filesystem $filesystem
     */
    public function __construct(
        Module $module,
        Filesystem $filesystem
    ) {

        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Check if the Module exists in this context
     * @return bool
     */
    public function exists()
    {
        $fs = $this->filesystem;
        $md = $this->module;

        if (! $fs->exists($md->getPath()) ||
            ! $this->getComponent(self::COMPONENT_MAGE_REGISTER_FILE)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * If the module exists in the context, it loads all the properties of the Module
     * @return ModuleFacade
     */
    public function load()
    {
        // TODO: Implement load() method.
    }

    /**
     * Enable context module (app/etc/modules)
     * @return bool
     */
    public function enable()
    {
        // TODO: Implement enable() method.
    }

    /**
     * Disable context module (app/etc/modules)
     * @return bool
     */
    public function disable()
    {
        // TODO: Implement disable() method.
    }

    /**
     * Return the context module
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return ModuleFacade
     */
    public function create()
    {
        // Create module structure if not exists
        if ($this->exists()) {
            throw new ModuleRuntimeException(self::MESSAGE_MODULE_EXISTS);
        }

        $this->filesystem->mkdir($this->getModule()->getPath());

        // Create Mage Register File
        $mageRegister = $this->getComponent(self::COMPONENT_MAGE_REGISTER_FILE);
        $mageRegister->create();

        // Create Helper Data
        $helper = $this->getComponent(self::COMPONENT_HELPER);
        $helper->create();

        // Create Module Config
        $config = $this->getComponent(self::COMPONENT_CONFIG);
        $config->create();

        return $this;
    }

    /**
     * Remove the context module
     * @return bool
     */
    public function remove()
    {
        try {
            if (! $this->exists()) {
                throw new ModuleRuntimeException(self::MESSAGE_MODULE_NOT_EXISTS);
            }

            //Remove Mage Register File
            $mageRegister = $this->getComponent(self::COMPONENT_MAGE_REGISTER_FILE);
            $mageRegister->remove();

            //Remove Module Structure
            $this->filesystem->remove($this->getModule()->getPath());

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $componentName
     * @return ComponentInterface
     */
    public function getComponent($componentName)
    {
        if (! array_key_exists($componentName, $this->components)) {
            $componentFactory = new ComponentFactory(
                $this,
                $this->filesystem
            );

            $this->components[$componentName] = $componentFactory($componentName);
        }

        return $this->components[$componentName];
    }
}
