<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Config;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ConfigTest extends TestCase
{
    /**
     * @expectedException  \RuntimeException
     */
    public function testTranslateConfigPrecaution()
    {
        $config = Config::getInstance();
        $config->set('translator', [
            'locale' => 'pt_BR',
            'translation_file_patterns' => [
                [
                    'type' => 'phparray',
                    'base_dir' => __DIR__ . '/i18n',
                    'pattern' => '%s/messages.php'
                ],
                [

                ]
            ]
        ]);

        $translator = $config::getTranslator();
    }
}
