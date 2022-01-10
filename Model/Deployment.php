<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model;

use MageSuite\Changelog\Api\Data\DeploymentInterface;
use MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Deployment extends \Magento\Framework\Model\AbstractModel
{

    protected $deploymentDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'changelog_deployment';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DeploymentInterfaceFactory $deploymentDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MageSuite\Changelog\Model\ResourceModel\Deployment $resource
     * @param \MageSuite\Changelog\Model\ResourceModel\Deployment\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        DeploymentInterfaceFactory $deploymentDataFactory,
        DataObjectHelper $dataObjectHelper,
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

