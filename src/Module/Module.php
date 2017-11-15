<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Config;

class Module
{
    const MAGE_ETC_FOLDER = 'app/etc';
    const MAGE_CODE_LOCAL = 'app/code/local';
    const MAGE_CODE_COMMUNITY = 'app/code/community';
    const MODULE_FOLDER_PATTERN = 'app/code/%s/%s/%s';
    const MESSAGE_INVALID_CODEPOOL = 'The codePool is invalid. Only accepted: "local" or "community"';
    const MESSAGE_INVALID_NAME = 'The module name needs to follow the following format: Vendor_Module';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $codePool;

    protected $moduleStructure = [
        'mage_etc_modules' => 'app/etc/modules',
        'module_etc' => self::MODULE_FOLDER_PATTERN . '/etc',
        'module_helper' => self::MODULE_FOLDER_PATTERN . '/Helper',
        'module_block' => self::MODULE_FOLDER_PATTERN . '/Block',
        'module_model' => self::MODULE_FOLDER_PATTERN . '/Model',
        'module_controller' => self::MODULE_FOLDER_PATTERN . '/controllers',
        'module_data' => self::MODULE_FOLDER_PATTERN . '/data',
        'module_sql' => self::MODULE_FOLDER_PATTERN . '/sql'
    ];

    protected $moduleBasicStructure = [
        'module_etc',
        'module_helper'
    ];

    protected $allowedCodePool = [
        'local',
        'community'
    ];

    /**
     * Module constructor.
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getModulePath()
    {
        return sprintf(
            self::MODULE_FOLDER_PATTERN,
            $this->validateCodePool(),
            $this->getVendorName(),
            $this->getModuleName()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->validateName();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getVendorName()
    {
        $moduleName = explode('_', $this->validateName());
        return $moduleName[0];
    }

    /**
     * @return mixed
     */
    public function getModuleName()
    {
        $moduleName = explode('_', $this->validateName());
        return $moduleName[1];
    }

    /**
     * @return string
     */
    public function getModuleAlias()
    {
        return strtolower($this->validateName());
    }

    /**
     * @return string
     */
    public function getCodePool()
    {
        return $this->validateCodePool();
    }

    /**
     * @param string $codePool
     * @return $this
     */
    public function setCodePool($codePool)
    {
        $this->codePool = $codePool;
        return $this;
    }

    /**
     * Validate Module Name
     *
     * @return string
     * @throws RuntimeException
     */
    public function validateName()
    {
        $moduleName = $this->name;
        $moduleNameExplode = explode('_', $moduleName);
        if (! substr_count($moduleName, '_')
            || count($moduleNameExplode) !== 2
            || ($moduleNameExplode[1] == '')) {
            throw new RuntimeException($this->translate(self::MESSAGE_INVALID_NAME));
        }

        return $moduleName;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function validateCodePool()
    {
        $codePool = $this->codePool;

        if (! in_array($codePool, $this->allowedCodePool)) {
            throw new RuntimeException($this->translate(self::MESSAGE_INVALID_CODEPOOL));
        }

        return $codePool;
    }

    /**
     * @param $text
     * @return string
     * @codeCoverageIgnore
     */
    public function translate($text)
    {
        $translator = Config::getTranslator();
        return $translator->translate($text);
    }
}
