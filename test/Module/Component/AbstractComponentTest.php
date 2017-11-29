<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\Component\Exception\RuntimeException;

class AbstractComponentTest extends AbstractComponent
{
    protected function setUp()
    {
        parent::setUp();
        $factory = $this->componentFactory;
        $this->componentContext = $factory(ModuleFacade::COMPONENT_CONFIG);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testFirstCheckCreateWhenComponentExists()
    {
        if (! $this->moduleFacade->exists()) {
            $this->moduleFacade->create();
        }

        $this->componentContext->create();
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

        $this->componentContext->create();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testLastCheckCreateWhenComponentNotExists()
    {
        if ($this->componentContext->exists()) {
            $this->componentContext->remove();
        }

        $this->componentContext->lastCheckCreate();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testFirstCheckRemoveWhenComponentNotExists()
    {
        if ($this->componentContext->exists()) {
            $this->componentContext->remove();
        }

        $this->componentContext->firstCheckRemove();
    }
}
