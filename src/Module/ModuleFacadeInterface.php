<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module;

interface ModuleFacadeInterface
{
    /**
     * Check if the Module exists in this context
     * @return bool
     */
    public function exists();

    /**
     * If the module exists in the context, it loads all the properties of the Module
     * @return ModuleFacade
     */
    public function load();

    /**
     * Remove the context module
     * @return bool
     */
    public function remove();

    /**
     * Enable context module (app/etc/modules)
     * @return bool
     */
    public function enable();

    /**
     * Disable context module (app/etc/modules)
     * @return bool
     */
    public function disable();

    /**
     * Return the context module
     * @return Module
     */
    public function getModule();

    /**
     * @return ModuleFacade
     */
    public function create();
}
