<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use ROB\M1devtools\Module\Component\Config;
use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\Component\Exception\RuntimeException;

class AbstractComponentTest extends AbstractComponent
{
    /**
     * @expectedException RuntimeException
     */
    public function testFirstCheckCreateWhenComponentExists()
    {
        if (! $this->moduleFacade->exists()) {
            $this->moduleFacade->create();
        }

        $factory = $this->componentFactory;
        /** @var Config $component */
        $component = $factory(ModuleFacade::COMPONENT_CONFIG);
        $component->create();
    }

    /**
     * @depends testFirstCheckCreateWhenComponentExists
     * @expectedException RuntimeException
     */
    public function testFirstCheckCreateWhenModuleNotExists()
    {
        if ($this->moduleFacade->exists()) {
            $this->moduleFacade->remove();
        }

        $factory = $this->componentFactory;
        /** @var Config $component */
        $component = $factory(ModuleFacade::COMPONENT_CONFIG);
        $component->create();
    }
}
