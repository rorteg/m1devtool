<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

interface ComponentInterface
{
    /**
     * Get the component name (file name)
     * @return string
     */
    public function getName();

    /**
     * Get the module context relative path from this component
     * @return string
     */
    public function getPath();

    /**
     * Get file extension
     * @return string
     */
    public function getExtension();

    /**
     * Create new self component
     * @return self
     */
    public function create();

    /**
     * Remove this component
     * @return bool
     */
    public function remove();

    /**
     * Save this component
     * @return self
     */
    public function save();

    /**
     * Load this component
     * @return self
     */
    public function load();

    /**
     * Get file path and name
     * @return string
     */
    public function getComponentFile();

    /**
     * Check if the Module exists in this context
     * @return bool
     */
    public function exists();

    /**
     * Get this component Twig Template
     * @return string
     */
    public function getTwigTemplate();
}
