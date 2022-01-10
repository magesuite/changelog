<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model;

use MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory;
use MageSuite\Changelog\Api\Data\DeploymentSearchResultsInterfaceFactory;
use MageSuite\Changelog\Api\DeploymentRepositoryInterface;
use MageSuite\Changelog\Model\ResourceModel\Deployment as ResourceDeployment;
use MageSuite\Changelog\Model\ResourceModel\Deployment\CollectionFactory as DeploymentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class DeploymentRepository implements DeploymentRepositoryInterface
{

    protected $resource;

    protected $deploymentFactory;

    protected $deploymentCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataDeploymentFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceDeployment $resource
     * @param DeploymentFactory $deploymentFactory
     * @param DeploymentInterfaceFactory $dataDeploymentFactory
     * @param DeploymentCollectionFactory $deploymentCollectionFactory
     * @param DeploymentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDeployment $resource,
        DeploymentFactory $deploymentFactory,
        DeploymentInterfaceFactory $dataDeploymentFactory,
        DeploymentCollectionFactory $deploymentCollectionFactory,
        DeploymentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->deploymentFactory = $deploymentFactory;
        $this->deploymentCollectionFactory = $deploymentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDeploymentFactory = $dataDeploymentFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
    ) {
        /* if (empty($deployment->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $deployment->setStoreId($storeId);
        } */
        
        $deploymentData = $this->extensibleDataObjectConverter->toNestedArray(
            $deployment,
            [],
            \MageSuite\Changelog\Api\Data\DeploymentInterface::class
        );
        
        $deploymentModel = $this->deploymentFactory->create()->setData($deploymentData);
        
        try {
            $this->resource->save($deploymentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the deployment: %1',
                $exception->getMessage()
            ));
        }
        return $deploymentModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($deploymentId)
    {
        $deployment = $this->deploymentFactory->create();
        $this->resource->load($deployment, $deploymentId);
        if (!$deployment->getId()) {
            throw new NoSuchEntityException(__('Deployment with id "%1" does not exist.', $deploymentId));
        }
        return $deployment->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->deploymentCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \MageSuite\Changelog\Api\Data\DeploymentInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
    ) {
        try {
            $deploymentModel = $this->deploymentFactory->create();
            $this->resource->load($deploymentModel, $deployment->getDeploymentId());
            $this->resource->delete($deploymentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Deployment: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($deploymentId)
    {
        return $this->delete($this->get($deploymentId));
    }
}

