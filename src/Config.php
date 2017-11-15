<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools;

use Noodlehaus\Config as NoodlehausConfig;
use ROB\M1devtools\Translator\TranslatorAdapter as Translator;

class Config extends NoodlehausConfig
{
    /**
     * @var Config|null
     */
    private static $instance = null;

    /**
     * @var Translator|null
     */
    private static $translator = null;

    /**
     * @var \Twig_Environment|null
     */
    private static $twig = null;

    /**
     * @return null|Config
     *
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * Config constructor.
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        // Setup/verify m1devtools Settings
        $config = [];
        $configFile = getcwd() . '/m1devtools.json';

        if (file_exists($configFile)) {
            $config = $configFile;
        }

        parent::__construct($config);
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    protected function getDefaults()
    {
        return [
            'template_path' => __DIR__ . '/../dev/m1devtools/template',
            'template_docheader' => __DIR__ . '/../dev/m1devtools/template/docheader',
            'translator' => [
                'locale' => 'en_US',
                'translation_file_patterns' => [
                    [
                        'type' => 'phparray',
                        'base_dir' => __DIR__ . '/../i18n',
                        'pattern' => '%s/messages.php'
                    ]
                ]
            ]
        ];
    }

    /**
     * @return \Twig_Environment
     *
     * @codeCoverageIgnore
     */
    public static function getTwig()
    {
        if (self::$twig === null) {
            $config = self::getInstance();
            // Setup Twig Template
            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem($config->get('template_path'));
            $loader->addPath($config->get('template_docheader'), 'docheader');
            self::$twig = new \Twig_Environment($loader);
        }

        return self::$twig;
    }

    /**
     * @return Translator
     */
    public static function getTranslator()
    {
        if (self::$translator === null) {
            $config = self::getInstance();
            $defaults = $config->getDefaults();

            $translatorConfig = array_replace_recursive(
                $defaults['translator'],
                $config->get('translator')
            );

            $translationFilePatterns = $translatorConfig['translation_file_patterns'];
            self::$translator = new Translator();

            foreach ($translationFilePatterns as $fp) {
                if (! isset($fp['type']) || ! isset($fp['base_dir']) || ! isset($fp['pattern'])) {
                    continue;
                }

                if (! isset($fp['text_domain'])) {
                    $fp['text_domain'] = 'default';
                }

                self::$translator->addTranslationFilePattern(
                    $fp['type'],
                    $fp['base_dir'],
                    $fp['pattern'],
                    $fp['text_domain']
                );
            }

            self::$translator->setLocale($translatorConfig['locale']);
            self::$translator->setFallbackLocale('en_US');

            self::$translator->setCache(null);
        }

        return self::$translator;
    }

    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     * @codeCoverageIgnore
     */
    public static function getConfig($key, $default = null)
    {
        $config = self::getInstance();
        return $config->get($key, $default);
    }

    /**
     * @param string $key
     * @param string $value
     * @codeCoverageIgnore
     */
    public static function setConfig($key, $value)
    {
        $config = self::getInstance();
        $config->set($key, $value);
    }
}
