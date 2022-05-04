<?php

namespace MageSuite\Changelog\Config\Changelog;

class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    protected ?string $schema = null;
    protected ?string $perFileSchema = null;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(
        \Magento\Framework\Module\Dir\Reader $moduleReader
    ) {
        $etcDir = $moduleReader->getModuleDir(\Magento\Framework\Module\Dir::MODULE_ETC_DIR, 'MageSuite_Changelog');
        $this->schema = sprintf('%s/changelog_merged.xsd', $etcDir);
        $this->perFileSchema = sprintf('%s/changelog.xsd', $etcDir);
    }

    /**
     * @return string|null
     */
    public function getSchema(): ?string
    {
        return $this->schema;
    }

    /**
     * @return string|null
     */
    public function getPerFileSchema(): ?string
    {
        return $this->perFileSchema;
    }
}
