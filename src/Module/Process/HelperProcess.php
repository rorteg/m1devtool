<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Process;

use ROB\M1devtools\Config;
use ROB\M1devtools\Module\Exception\RuntimeException;

class HelperProcess extends AbstractProcess implements ProcessInterface
{
    const MESSAGE_HELPER_EXISTS = 'The Helper %s already exists!';

    /**
     * @return mixed|void
     */
    public function process()
    {
        $this->createHelper('Data');
    }

    /**
     * @param $helperName
     * @return bool
     */
    public function checkIfHelperExists($helperName)
    {
        $module = $this->getModule();
        return $this->checkIfFileExistsInModuleContext(
            $module::MODULE_FOLDER_HELPER . $helperName . '.php'
        );
    }

    /**
     * @param $helperName
     */
    public function createHelper($helperName = 'Data')
    {
        $helperName = ucfirst($helperName);

        if ($this->checkIfHelperExists($helperName)) {
            throw new RuntimeException(sprintf(
                Config::getTranslator()->translate(self::MESSAGE_HELPER_EXISTS),
                $helperName
            ));
        }

        $module = $this->getModule();
        $twig = Config::getTwig();

        $this->getFs()->dumpFile(
            $module->getModulePath($module::MODULE_PATH_ID_HELPER) . '/Data.php',
            $twig->render('module/Helper/Data.php.twig', ['module' => $module])
        );
    }
}
