<?php

namespace MageSuite\Changelog\Config\Changelog;

use Magento\Framework\Module\Dir;

class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    protected $_schema = null;
    protected $_perFileSchema = null;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(
        \Magento\Framework\Module\Dir\Reader $moduleReader
    ) {
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'MageSuite_Changelog');
        $this->_schema = $etcDir . '/changelog_merged.xsd';
        $this->_perFileSchema = $etcDir . '/changelog.xsd';
    }

    /**
     * @return string|null
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->_perFileSchema;
    }
}
