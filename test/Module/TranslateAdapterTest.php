<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Config;
use ROB\M1devtools\Translator\TranslatorAdapter;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TranslateAdapterTest extends TestCase
{
    /**
     * @var TranslatorAdapter
     */
    private $translator;

    private $configTranslator = [
        'locale' => 'pt_BR',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/i18n',
                'pattern' => '%s/messages.php'
            ]
        ]
    ];

    protected function setUp()
    {
        Config::setConfig('translator', $this->configTranslator);
        $this->translator = Config::getTranslator();
    }

    /**
     * @dataProvider    provideFileTranslate
     */
    public function testTranslateAdapterCorrectConfiguration($message, $translated)
    {
        $translator = $this->translator;
        $this->assertEquals($translator->translate($message), $translated);
    }

    public function provideFileTranslate()
    {
        $translate = require __DIR__ . '/i18n/pt_BR/messages.php';
        $data = [];

        foreach ($translate as $message => $translated) {
            $data[] = [$message, $translated];
        }

        return $data;
    }
}
