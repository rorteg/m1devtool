<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Module\Component;

use ROB\M1devtools\Filesystem\FilesystemInterface;
use ROB\M1devtools\Module\ModuleFacade;
use ROB\M1devtools\Module\Component\Exception\RuntimeException;
use ROB\M1devtools\Config;

abstract class AbstractComponent
{
    /**
     * @var ModuleFacade
     */
    protected $moduleFacade;

    /**
     * @var Filesystem
     */
    protected $fs;

    public function __construct(
        ModuleFacade $moduleFacade,
        FilesystemInterface $fs
    ) {

        $this->moduleFacade = $moduleFacade;
        $this->fs = $fs;
    }

    /**
     * Check if the Module exists in this context
     * @return bool
     */
    public function exists()
    {
        return $this->fs->exists($this->getComponentFile());
    }

    /**
     * Create new self component
     * @return self
     */
    public function create()
    {
        $this->firstCheckCreate();

        // Create Helper File
        $twig = Config::getTwig();
        $module = $this->moduleFacade->getModule();
        $newFile = $this->getComponentFile();

        $newFileContent = $twig->render($this->getTwigTemplate(), ['module' => $module]);

        $this->fs->dumpFile(
            $newFile,
            $newFileContent
        );

        $this->lastCheckCreate();
    }

    /**
     * First Check
     */
    public function firstCheckCreate()
    {
        // Check if the module folder exists
        if (! $this->fs->exists($this->moduleFacade->getModule()->getPath())) {
            throw new RuntimeException('The Module do not exists');
        }

        // Check if the Component File exists
        if ($this->exists()) {
            throw new RuntimeException(
                sprintf('The Component: %s already exists to this Module', $this->getComponentFile())
            );
        }
    }

    /**
     * Last Check
     */
    public function lastCheckCreate()
    {
        // Check if the file was created
        if (! $this->exists()) {
            throw new RuntimeException('There was a problem trying to create a file');
        }
    }

    /**
     * Get file path and name
     * @return string
     */
    public function getComponentFile()
    {
        return $this->getPath() . '/'
            . $this->getName()
            . $this->getExtension();
    }
}
