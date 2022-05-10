<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model;

class Changelog extends \Magento\Framework\Model\AbstractModel
{

    protected \MageSuite\Changelog\Api\Data\ChangelogInterfaceFactory $changelogDataFactory;

    protected \Magento\Framework\Api\DataObjectHelper $dataObjectHelper;

    // phpcs:ignore
    protected $_eventPrefix = 'changelog_entity';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ChangelogInterfaceFactory $changelogDataFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \MageSuite\Changelog\Model\ResourceModel\Changelog $resource
     * @param \MageSuite\Changelog\Model\ResourceModel\Changelog\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \MageSuite\Changelog\Api\Data\ChangelogInterfaceFactory $changelogDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \MageSuite\Changelog\Model\ResourceModel\Changelog $resource,
        \MageSuite\Changelog\Model\ResourceModel\Changelog\Collection $resourceCollection,
        array $data = []
    ) {
        $this->changelogDataFactory = $changelogDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function getDataModel(): \MageSuite\Changelog\Api\Data\ChangelogInterface
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
