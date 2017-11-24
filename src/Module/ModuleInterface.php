<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

interface ModuleInterface
{
    const MAGE_CODE_FOLDER = 'app/code';
    const MAGE_REGISTER_ETC_FOLDER = 'app/etc/modules';

    /**
     * return Vendor_Module
     * @return string
     */
    public function getFullName();

    /**
     * return Module (Name of module without vendor name).
     * @return string
     */
    public function getName();

    /**
     * return Only the name of the Vendor
     * @return string
     */
    public function getVendor();

    /**
     * return local|community
     * @return string
     */
    public function getCodePool();

    /**
     * return relative path ex: app/code/local/Vendor/Module
     * @return string
     */
    public function getPath();

    /**
     * return Module alias ex: vendor_module
     * @return string
     */
    public function getAlias();

    /**
     * @param string $version set version of the module
     * @return Module
     */
    public function setVersion($version);

    /**
     * Get Module version
     * @return string
     */
    public function getVersion();

    /**
     * Get relative path to register file (app/etc/modules/Vendor_Module.xml)
     * @return string
     */
    public function getMageRegistryFile();
}
