<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model;

use MageSuite\Changelog\Api\ChangelogRepositoryInterface;
use MageSuite\Changelog\Api\Data\ChangelogInterfaceFactory;
use MageSuite\Changelog\Api\Data\ChangelogSearchResultsInterfaceFactory;
use MageSuite\Changelog\Model\ResourceModel\Changelog as ResourceChangelog;
use MageSuite\Changelog\Model\ResourceModel\Changelog\CollectionFactory as ChangelogCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class ChangelogRepository implements ChangelogRepositoryInterface
{

    protected $resource;

    protected $changelogFactory;

    protected $changelogCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataChangelogFactory;


    private $storeManager;

    private $collectionProcessor;

    protected $groupChangelogByKey;

    /**
     * @param ResourceChangelog $resource
     * @param ChangelogFactory $changelogFactory
     * @param ChangelogInterfaceFactory $dataChangelogFactory
     * @param ChangelogCollectionFactory $changelogCollectionFactory
     * @param ChangelogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceChangelog $resource,
        ChangelogFactory $changelogFactory,
        ChangelogInterfaceFactory $dataChangelogFactory,
        ChangelogCollectionFactory $changelogCollectionFactory,
        ChangelogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        \MageSuite\Changelog\Service\GroupChangelogByKey $groupChangelogByKey
    ) {
        $this->resource = $resource;
        $this->changelogFactory = $changelogFactory;
        $this->changelogCollectionFactory = $changelogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataChangelogFactory = $dataChangelogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->groupChangelogByKey = $groupChangelogByKey;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    ) {
        $changelogModel = $this->changelogFactory->create()->setData($changelogData);
        
        try {
            $this->resource->save($changelogModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the changelog: %1',
                $exception->getMessage()
            ));
        }
        return $changelogModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($changelogId)
    {
        $changelog = $this->changelogFactory->create();
        $this->resource->load($changelog, $changelogId);
        if (!$changelog->getId()) {
            throw new NoSuchEntityException(__('Changelog with id "%1" does not exist.', $changelogId));
        }
        return $changelog->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria = null
    ) {
        $collection = $this->changelogCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();

        if($criteria) {
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

    public function getListAsNestedArray($criteria = null, $groupingKey = 'module'){
        $list = $this->getList($criteria);
        $entries = [];
        foreach($list->getItems() as $item){
            $entries[] = $item->getData();
        }

        $grouped = $this->groupChangelogByKey->execute($entries, $groupingKey);
        return $grouped;
    }

    public function getListAsTimeline($criteria = null, $groupingKey = 'version_date'){
        $list = $this->getList($criteria);
        $entries = [];
        foreach($list->getItems() as $item){
            $entries[] = $item->getData();
        }

        return $entries;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    ) {
        try {
            $changelogModel = $this->changelogFactory->create();
            $this->resource->load($changelogModel, $changelog->getChangelogId());
            $this->resource->delete($changelogModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Changelog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($changelogId)
    {
        return $this->delete($this->get($changelogId));
    }
}

