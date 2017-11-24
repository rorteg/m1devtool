<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Module\Exception\InvalidArgumentException;

class Module implements ModuleInterface
{
    private $fullName = null;

    private $name = null;

    private $vendor = null;

    private $codePool = null;

    private $path = null;

    private $alias = null;

    private $version = '0.1.0';

    private $allowedCodePool = ['local', 'community'];

    /**
     * Module constructor.
     * @param string|null $fullName
     * @param string $codePool
     */
    public function __construct($fullName = null, $codePool = 'local')
    {
        if ($fullName === null) {
            throw new InvalidArgumentException('The module name is a required parameter');
        }

        if (! $this->validateFullName($fullName)) {
            throw new InvalidArgumentException('The module name needs to follow the following format: Vendor_Module');
        }

        if (! in_array($codePool, $this->allowedCodePool)) {
            throw new InvalidArgumentException('Invalid Code Pool');
        }

        $this->fullName = $fullName;
        $this->codePool = $codePool;
    }

    /**
     * Validate Module full name. Ex: Vendor_Module
     * @param string $fullName
     * @return bool
     */
    public function validateFullName($fullName = null)
    {
        if ($fullName == null) {
            $fullName = $this->getFullName();
        }

        $moduleNameExplode = explode('_', $fullName);
        if (! substr_count($fullName, '_')
            || count($moduleNameExplode) !== 2
            || ($moduleNameExplode[1] == '')) {
            return false;
        }

        return true;
    }

    /**
     * return Vendor_Module
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * return Module (Name of module without vendor name).
     * @return string
     */
    public function getName()
    {
        if ($this->name === null) {
            $this->setNameAndVendor();
        }

        return $this->name;
    }

    /**
     * return Only the name of the Vendor
     * @return string
     */
    public function getVendor()
    {
        if ($this->vendor === null) {
            $this->setNameAndVendor();
        }

        return $this->vendor;
    }

    /**
     * Auxiliary method for internal set properties
     */
    private function setNameAndVendor()
    {
        $fullName = explode('_', $this->getFullName());
        $this->vendor = $fullName[0];
        $this->name = $fullName[1];
    }

    /**
     * return local|community
     * @return string
     */
    public function getCodePool()
    {
        return $this->codePool;
    }

    /**
     * return relative path ex: app/code/local/Vendor/Module
     * @return string
     */
    public function getPath()
    {
        if ($this->path === null) {
            $this->path = self::MAGE_CODE_FOLDER .
            '/' . $this->getCodePool() .
            '/' . $this->getVendor() .
            '/' . $this->getName();
        }

        return $this->path;
    }

    /**
     * return Module alias ex: vendor_module
     * @return string
     */
    public function getAlias()
    {
        if ($this->alias === null) {
            $this->alias = strtolower($this->getFullName());
        }
        return $this->alias;
    }

    /**
     * @param string $version set version of the module
     * @return Module
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get Module version
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get relative path to register file (app/etc/modules/Vendor_Module.xml)
     * @return string
     */
    public function getMageRegistryFile()
    {
        return self::MAGE_REGISTER_ETC_FOLDER . '/' . $this->getFullName() . '.xml';
    }
}
