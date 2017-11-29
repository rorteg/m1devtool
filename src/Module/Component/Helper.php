<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Filesystem\FilesystemInterface;

class Helper extends AbstractComponent implements ComponentInterface
{
    const MESSAGE_COMPONENT_NOT_EXISTS = 'The Helper File not exists to this Module';
    const MESSAGE_COMPONENT_EXISTS = 'The Helper File already exists to this Module';
    const TEMPLATE = '';

    /**
     * @var ModuleFacade
     */
    protected $moduleFacade;

    /**
     * @var FilesystemInterface
     */
    protected $fs;

    /**
     * @var string
     */
    protected $name = 'Data';

    /**
     * @param $name
     * @return $this
     * @codeCoverageIgnore
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the component name (file name)
     * @return string
     */
    public function getName()
    {
        return ucfirst($this->name);
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
        return $this->moduleFacade->getModule()->getPath() . '/Helper';
    }

    /**
     * Get file extension
     * @return string
     */
    public function getExtension()
    {
        return '.php';
    }

    /**
     * Get this component Twig Template
     * @return string
     */
    public function getTwigTemplate()
    {
        return 'module/Helper/Data.php.twig';
    }
}
