<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

use ROB\M1devtools\Module\Component\Exception\RuntimeException;
use ROB\M1devtools\Module\ModuleFacade;

class MageRegisterFile extends AbstractComponent implements ComponentInterface
{
    const MESSAGE_COMPONENT_NOT_EXISTS = 'The Magento Register File not exists to this Module';
    const MESSAGE_COMPONENT_EXISTS = 'The Magento Register File already exists to this Module';

    /**
     * Get the component name (file name)
     * @return string
     */
    public function getName()
    {
        return $this->moduleFacade->getModule()->getFullName();
    }

    /**
     * Remove this component
     * @return bool
     */
    public function remove()
    {
        // Check if this Module exists
        if (! $this->moduleFacade->exists()) {
            throw new RuntimeException(ModuleFacade::MESSAGE_MODULE_NOT_EXISTS);
        }

        // Check if the Magento Register File exists
        if (! $this->exists()) {
            throw new RuntimeException(self::MESSAGE_COMPONENT_NOT_EXISTS);
        }

        $this->fs->remove($this->getComponentFile());
    }

    /**
     * @return string
     */
    public function getComponentFile()
    {
        return $this->getPath() . '/'
            . $this->moduleFacade->getModule()->getFullName()
            . $this->getExtension();
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
        return 'app/etc/modules';
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
     * Get this component Twig Template
     * @return string
     */
    public function getTwigTemplate()
    {
        return 'app/etc/modules/Vendor_Module.xml.twig';
    }
}
