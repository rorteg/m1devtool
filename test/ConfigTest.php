<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Config;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ConfigTest extends TestCase
{
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

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(Config::MESSAGE_INVALID_CONFIG_TRANSLATOR);
        $config::getTranslator();
    }

    public function testTranslatorGetInstance()
    {
        $this->assertInstanceOf(TranslatorInterface::class, Config::getTranslator());
    }

    public function testTwigGetInstance()
    {
        $this->assertInstanceOf(\Twig_Environment::class, Config::getTwig());
    }
}
