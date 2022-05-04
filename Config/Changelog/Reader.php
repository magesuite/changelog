<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Config\Changelog;

class Reader extends \Magento\Framework\Config\Reader\Filesystem
{

    protected $_idAttributes = [
        '/config/module' => 'id',
    ];

    public function __construct(
        \MageSuite\Changelog\Config\Changelog\FileResolver $fileResolver,
        Converter $converter,
        SchemaLocator $schemaLocator,
        \Magento\Framework\Config\ValidationStateInterface $validationState,
        $fileName = 'changelog.xml',
        $idAttributes = [],
        $domDocumentClass = \Magento\Framework\Config\Dom::class,
        $defaultScope = 'primary'
    ) {
        parent::__construct(
            $fileResolver,
            $converter,
            $schemaLocator,
            $validationState,
            $fileName,
            $idAttributes,
            $domDocumentClass,
            $defaultScope
        );
    }
}
