<?php

namespace MageSuite\Changelog\Config\Changelog;

class FileResolver implements \Magento\Framework\Config\FileResolverInterface
{

    protected \Magento\Framework\Module\Dir\Reader $moduleReader;
    protected \Magento\Framework\Config\FileIteratorFactory $iteratorFactory;
    protected \Magento\Framework\Filesystem $filesystem;
    protected \Magento\Framework\Component\ComponentRegistrar $componentRegistrar;
    protected \Magento\Framework\Filesystem\Io\File $fileIo;

    /**
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Config\FileIteratorFactory $iteratorFactory
     * @param \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     * @param \Magento\Framework\Filesystem\Io\File $fileIo
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Config\FileIteratorFactory $iteratorFactory,
        \Magento\Framework\Component\ComponentRegistrar $componentRegistrar,
        \Magento\Framework\Filesystem\Io\File $fileIo
    ) {
        $this->iteratorFactory = $iteratorFactory;
        $this->filesystem = $filesystem;
        $this->componentRegistrar = $componentRegistrar;
        $this->fileIo = $fileIo;
    }

    public function get($filename, $scope)
    {
        $modulePaths = $this->componentRegistrar->getPaths(\Magento\Framework\Component\ComponentRegistrar::MODULE);
        $themePaths = $this->componentRegistrar->getPaths(\Magento\Framework\Component\ComponentRegistrar::THEME);

        $changelogFiles = $this->getChangelogFiles(array_merge($modulePaths, $themePaths));

        return $this->iteratorFactory->create($changelogFiles);
    }

    protected function getChangelogFiles($paths): array
    {
        $changelogFilePaths = [];
        foreach ($paths as $id => $path) {
            $changelogFilePath = sprintf('%s/etc/changelog.xml', $path);
            if (!$this->fileIo->fileExists($changelogFilePath)) {
                continue;
            }

            $changelogFilePaths[] = $changelogFilePath;
        }

        return $changelogFilePaths;
    }
}
