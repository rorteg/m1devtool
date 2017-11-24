<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\ModuleFacadeFactory;

class ModuleFacadeFactoryTest extends TestCase
{
    public function testInstantiateFacade()
    {
        $moduleFactory = new ModuleFacadeFactory;
        $module = $moduleFactory('ROB_Test');

        $this->assertInstanceOf(ModuleFacade::class, $module);
    }
}
