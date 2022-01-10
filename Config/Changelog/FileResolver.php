<?php

namespace MageSuite\Changelog\Config\Changelog;

class FileResolver implements \Magento\Framework\Config\FileResolverInterface
{
    /**
     * Module configuration file reader
     *
     * @var \Magento\Framework\Module\Dir\Reader
     */
    protected $_moduleReader;

    /**
     * File iterator factory
     *
     * @var \Magento\Framework\Config\FileIteratorFactory
     */
    protected $iteratorFactory;

    /**
     * Filesystem
     *
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    protected $componentRegistrar;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Config\FileIteratorFactory $iteratorFactory
     */
    public function __construct(
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Config\FileIteratorFactory $iteratorFactory,
        \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
    ) {
        $this->iteratorFactory = $iteratorFactory;
        $this->filesystem = $filesystem;
        $this->_moduleReader = $moduleReader;
        $this->componentRegistrar = $componentRegistrar;
    }

    public function get($filename, $scope)
    {
        $modulePaths = $this->componentRegistrar->getPaths(\Magento\Framework\Component\ComponentRegistrar::MODULE);
        $themePaths = $this->componentRegistrar->getPaths(\Magento\Framework\Component\ComponentRegistrar::THEME);

        $changelogs = $this->getChangelogFiles(array_merge($modulePaths, $themePaths));

        $iterator = $this->iteratorFactory->create($changelogs);

        return $iterator;
    }

    protected function getChangelogFiles($paths){
        $changelogs = [];
        foreach($paths as $id => $path){
            if(file_exists($path.DIRECTORY_SEPARATOR.'etc'.DIRECTORY_SEPARATOR.'changelog.xml')){
                $changelogs[] = $path.DIRECTORY_SEPARATOR.'etc'.DIRECTORY_SEPARATOR.'changelog.xml';
            }
        }

        return $changelogs;
    }
}
