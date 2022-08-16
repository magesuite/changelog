<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model;

class DeploymentRepository implements \MageSuite\Changelog\Api\DeploymentRepositoryInterface
{

    protected ResourceModel\Deployment $resourceDeployment;
    protected DeploymentFactory $deploymentFactory;
    protected ResourceModel\Deployment\CollectionFactory $deploymentCollectionFactory;
    protected \MageSuite\Changelog\Api\Data\DeploymentSearchResultsInterfaceFactory $searchResultsFactory;
    protected \Magento\Framework\Api\DataObjectHelper $dataObjectHelper;
    protected \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor;
    protected \MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory $dataDeploymentFactory;
    protected \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor;
    protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;
    protected \Magento\Framework\Api\SortOrderBuilder $sortBuilder;
    protected \Magento\Store\Model\StoreManagerInterface $storeManager;
    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;
    protected \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter;

    public function __construct(
        \MageSuite\Changelog\Model\ResourceModel\Deployment $resourceDeployment,
        \MageSuite\Changelog\Model\DeploymentFactory $deploymentFactory,
        \MageSuite\Changelog\Api\Data\DeploymentInterfaceFactory $dataDeploymentFactory,
        \MageSuite\Changelog\Model\ResourceModel\Deployment\CollectionFactory $deploymentCollectionFactory,
        \MageSuite\Changelog\Api\Data\DeploymentSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortBuilder
    ) {
        $this->resourceDeployment = $resourceDeployment;
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
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortBuilder = $sortBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
    ) {

        $deploymentData = $this->extensibleDataObjectConverter->toNestedArray(
            $deployment,
            [],
            \MageSuite\Changelog\Api\Data\DeploymentInterface::class
        );

        $deploymentModel = $this->deploymentFactory->create()->setData($deploymentData);

        try {
            $this->resourceDeployment->save($deploymentModel);
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
        $this->resourceDeployment->load($deployment, $deploymentId);
        if (!$deployment->getId()) {
            throw new NoSuchEntityException(__('Deployment with id "%1" does not exist.', $deploymentId));
        }
        return $deployment->getDataModel();
    }

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria = null
    ) {
        $searchResults = $this->searchResultsFactory->create();
        $collection = $this->deploymentCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \MageSuite\Changelog\Api\Data\DeploymentInterface::class
        );

        if ($criteria) {
            $this->collectionProcessor->process($criteria, $collection);
            $searchResults->setSearchCriteria($criteria);
        }

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
            $this->resourceDeployment->load($deploymentModel, $deployment->getDeploymentId());
            $this->resourceDeployment->delete($deploymentModel);
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
    public function deleteById($deploymentId): bool
    {
        return $this->delete($this->get($deploymentId));
    }

    public function getLastDeployment()
    {

        $sortOrder = $this->sortBuilder
            ->setField('deployed_at')
            ->setDescendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->setPageSize(1)
            ->create();

        $deploymentsList = $this->getList($searchCriteria);
        if ($deploymentsList->getTotalCount()==0) {
            return $this->deploymentFactory->create();
        }

        return $deploymentsList->getItems()[0];
    }
}
