<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools;

use Noodlehaus\Config as NoodlehausConfig;

class Config extends NoodlehausConfig
{

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
            'template_path' => getcwd() . '/vendor/rorteg/m1devtools/dev/template',
            'template_docheader' => getcwd() . '/vendor/rorteg/m1devtools/dev/template/docheader'
        ];
    }

    /**
     * @return \Twig_Environment
     *
     * @codeCoverageIgnore
     */
    public function getTwig()
    {
        // Setup Twig Template
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($this->get('template_path'));
        $loader->addPath($this->get('docheader_template'), 'docheader');
        return new \Twig_Environment($loader);
    }
}
