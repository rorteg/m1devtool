<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROBTest\M1devtools\Filesystem;

use PHPUnit\Framework\TestCase;
use ROB\M1devtools\Filesystem\FilesystemFactory;
use ROB\M1devtools\Filesystem\FilesystemInterface;

class FilesistemFactoryTest extends TestCase
{
    public function testInstanceOfFromAdapter()
    {
        $filesystemFactory = new FilesystemFactory();
        $this->assertInstanceOf(FilesystemInterface::class, $filesystemFactory());
    }
}
