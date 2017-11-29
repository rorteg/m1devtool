<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use ROB\M1devtools\Module\Component\MageRegisterFile;
use ROB\M1devtools\Module\ModuleFacade;

class MageRegisterFileTest extends AbstractComponent
{
    /**
     * @var MageRegisterFile
     */
    private $mageRegisterFile;

    protected function setUp()
    {
        parent::setUp();
        $factory = $this->componentFactory;
        $this->mageRegisterFile = $factory(ModuleFacade::COMPONENT_MAGE_REGISTER_FILE);
    }

    public function testGetComponentName()
    {
        $expected = $this->moduleFacade->getModule()->getFullName();
        $this->assertEquals($expected, $this->mageRegisterFile->getName());
    }
}
