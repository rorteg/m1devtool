<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

use ROB\M1devtools\Module\Exception\ProcessException;
use ROB\M1devtools\Module\Exception\RuntimeException;
use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Process\ProcessInterface;

class Module
{
    const MAGE_ETC_FOLDER = 'app/etc';
    const MAGE_CODE_LOCAL = 'app/code/local';
    const MAGE_CODE_COMMUNITY = 'app/code/community';
    const MODULE_FOLDER_PATTERN = 'app/code/%s/%s/%s';
    const MESSAGE_INVALID_CODEPOOL = 'The codePool is invalid. Only accepted: "local" or "community"';
    const MESSAGE_INVALID_NAME = 'The module name needs to follow the following format: Vendor_Module';
    const MESSAGE_INVALID_INSTANCEOF = 'Process class "%s" needs to implement the ProcessInterface interface';
    const MODULE_PATH_ID_MAGE_ETC_MODULES = 'mage_etc_modules';
    const MODULE_PATH_ID_ETC = 'module_etc';
    const MODULE_PATH_ID_HELPER = 'module_helper';
    const MODULE_PATH_ID_BLOCK = 'module_block';
    const MODULE_PATH_ID_MODEL = 'module_model';
    const MODULE_PATH_ID_CONTROLLER = 'module_controller';
    const MODULE_PATH_ID_DATA = 'module_data';
    const MODULE_PATH_ID_SQL = 'module_sql';
    const MODULE_FOLDER_ETC = 'etc';
    const MODULE_FOLDER_HELPER = 'Helper';
    const MODULE_FOLDER_BLOCK = 'Block';
    const MODULE_FOLDER_MODULE = 'Model';
    const MODULE_FOLDER_CONTROLLERS = 'controllers';
    const MODULE_FOLDER_DATA = 'data';
    const MODULE_FOLDER_SQL = 'sql';
    const MODMAN_FILE = 'modman';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $codePool;

    protected $moduleStructure = [
        self::MODULE_PATH_ID_MAGE_ETC_MODULES => 'app/etc/modules',
        self::MODULE_PATH_ID_ETC => self::MODULE_FOLDER_PATTERN . '/etc',
        self::MODULE_PATH_ID_HELPER => self::MODULE_FOLDER_PATTERN . '/Helper',
        self::MODULE_PATH_ID_BLOCK => self::MODULE_FOLDER_PATTERN . '/Block',
        self::MODULE_PATH_ID_MODEL => self::MODULE_FOLDER_PATTERN . '/Model',
        self::MODULE_PATH_ID_CONTROLLER => self::MODULE_FOLDER_PATTERN . '/controllers',
        self::MODULE_PATH_ID_DATA => self::MODULE_FOLDER_PATTERN . '/data',
        self::MODULE_PATH_ID_SQL => self::MODULE_FOLDER_PATTERN . '/sql'
    ];

    protected $moduleBasicStructure = [
        self::MODULE_PATH_ID_ETC,
        self::MODULE_PATH_ID_HELPER
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
     * @param string $pathKey
     * @return string
     */
    public function getModulePath($pathKey = '')
    {
        $pattern = self::MODULE_FOLDER_PATTERN;
        if ($pathKey != '') {
            if (! array_key_exists($pathKey, $this->moduleStructure)) {
                throw new RuntimeException('This folder is not default.');
            }

            $pattern = $this->moduleStructure[$pathKey];
        }

        return sprintf(
            $pattern,
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
        $this->codePool = strtolower($codePool);
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

    /**
     * @param string $processClassName
     * @return mixed
     */
    public function runProcess($processClassName)
    {
        $process = new $processClassName($this);

        if (! $process instanceof ProcessInterface) {
            throw new ProcessException(sprintf(self::MESSAGE_INVALID_INSTANCEOF, $processClassName));
        }
        return $process->process();
    }

    /**
     * @return array
     */
    public function getModuleBasicStructure()
    {
        return array_map(function ($pathId) {
            return $this->getModulePath($pathId);
        }, $this->moduleBasicStructure);
    }

    /**
     * @return array
     */
    public function getModuleStructure()
    {
        return $this->moduleStructure;
    }
}
