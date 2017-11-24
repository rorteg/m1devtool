<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Module\Component;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Filesystem\FilesystemAdapter;
use ROB\M1devtools\Module\Component\MageRegisterFile;
use ROB\M1devtools\Module\ModuleFacadeFactory;

class MageRegisterFileTest extends TestCase
{
    /**
     * @var MageRegisterFile
     */
    private $mageRegisterFile;

    protected function setUp()
    {
        $moduleFacadeFactory = new ModuleFacadeFactory();
        $moduleFacade = $moduleFacadeFactory('ROB_Test');
        $this->mageRegisterFile = new MageRegisterFile(
            $moduleFacade,
            new FilesystemAdapter()
        );
    }

    public function testCreateNewModule()
    {
        //$this->assertInstanceOf(MageRegisterFile::class, $this->mageRegisterFile->create());
    }
}
