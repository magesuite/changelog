<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model;

class Deployment extends \Magento\Framework\Model\AbstractModel
{

    protected \MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory $deploymentDataFactory;

    protected \Magento\Framework\Api\DataObjectHelper $dataObjectHelper;

    // phpcs:ignore
    protected $_eventPrefix = 'changelog_deployment';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory $deploymentDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \MageSuite\Changelog\Model\ResourceModel\Deployment $resource,
        \MageSuite\Changelog\Model\ResourceModel\Deployment\Collection $resourceCollection,
        array $data = []
    ) {
        $this->deploymentDataFactory = $deploymentDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve deployment model with deployment data
     * @return DeploymentInterface
     */
    public function getDataModel()
    {
        $deploymentData = $this->getData();

        $deploymentDataObject = $this->deploymentDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $deploymentDataObject,
            $deploymentData,
            DeploymentInterface::class
        );

        return $deploymentDataObject;
    }
}
