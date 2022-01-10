<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model;

use MageSuite\Changelog\Api\Data\ChangelogInterface;
use MageSuite\Changelog\Api\Data\ChangelogInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Changelog extends \Magento\Framework\Model\AbstractModel
{

    protected $changelogDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'changelog_entity';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ChangelogInterfaceFactory $changelogDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MageSuite\Changelog\Model\ResourceModel\Changelog $resource
     * @param \MageSuite\Changelog\Model\ResourceModel\Changelog\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ChangelogInterfaceFactory $changelogDataFactory,
        DataObjectHelper $dataObjectHelper,
        \MageSuite\Changelog\Model\ResourceModel\Changelog $resource,
        \MageSuite\Changelog\Model\ResourceModel\Changelog\Collection $resourceCollection,
        array $data = []
    ) {
        $this->changelogDataFactory = $changelogDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve changelog model with changelog data
     * @return ChangelogInterface
     */
    public function getDataModel()
    {
        $changelogData = $this->getData();
        
        $changelogDataObject = $this->changelogDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $changelogDataObject,
            $changelogData,
            ChangelogInterface::class
        );
        
        return $changelogDataObject;
    }
}

