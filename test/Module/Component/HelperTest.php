<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use ROB\M1devtools\Module\ModuleFacade;

class HelperTest extends AbstractComponent
{
    protected function setUp()
    {
        parent::setUp();
        $factory = $this->componentFactory;
        $this->componentContext = $factory(ModuleFacade::COMPONENT_HELPER);
    }

    public function testGetName()
    {
        $this->assertEquals('Data', $this->componentContext->getName());
        $this->componentContext->setName('customhelpername');
        $this->assertEquals('Customhelpername', $this->componentContext->getName());
        $this->componentContext->setName('data');
    }
}
