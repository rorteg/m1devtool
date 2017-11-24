<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

class Config extends AbstractComponent implements ComponentInterface
{
    /**
     * @var string
     */
    protected $name = 'config';

    protected $twigTemplate = 'module/etc/config.xml.twig';

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the component name (file name)
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Remove this component
     * @return bool
     */
    public function remove()
    {
        // TODO: Implement remove() method.
    }

    /**
     * Save this component
     * @return self
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * Load this component
     * @return self
     */
    public function load()
    {
        // TODO: Implement load() method.
    }

    /**
     * Get the module context relative path from this component
     * @return string
     */
    public function getPath()
    {
        return $this->moduleFacade->getModule()->getPath() . '/etc';
    }

    /**
     * Get file extension
     * @return string
     */
    public function getExtension()
    {
        return '.xml';
    }

    /**
     * @param string $twigTemplate
     */
    public function setTwigTemplate($twigTemplate)
    {
        $this->twigTemplate = $twigTemplate;
    }

    /**
     * Get this component Twig Template
     * @return string
     */
    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }
}
