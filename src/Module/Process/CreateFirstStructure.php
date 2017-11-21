<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Process;

use ROB\M1devtools\Config;

class CreateFirstStructure extends AbstractProcess implements ProcessInterface
{
    public function process()
    {
        if ($this->checkIfModuleStructureExists()) {
            $message = sprintf(
                Config::getTranslator()->translate(self::MESSAGE_MODULE_EXISTS),
                $this->getModule()->getName()
            );

            throw new RuntimeException($message);
        }
        $this->createBasicStructure();
        $this->createModuleConfigFile();
        $this->getModule()->runProcess(HelperProcess::class);
    }

    /**
     * Creates the basic module directories
     */
    public function createBasicStructure()
    {
        $basicStructure = $this->getModule()->getModuleBasicStructure();

        foreach ($basicStructure as $folder) {
            $this->getFs()->mkdir($folder);
            $this->addInModman($folder, $folder);
        }
    }

    /**
     * Creates the config.xml file for the module
     */
    public function createModuleConfigFile()
    {
        $twig = Config::getTwig();
        $module = $this->getModule();

        $this->getFs()->dumpFile(
            $module->getModulePath($module::MODULE_PATH_ID_ETC) . '/config.xml',
            $twig->render('module/etc/config.xml.twig', ['module' => $module])
        );
    }
}
