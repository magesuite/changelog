<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Get extends \Magento\Framework\App\Action\Action {

    protected $getChangelogEntries;

    protected $jsonResultFactory;

    protected $searchCriteriaBuilder;

    public function __construct(
        \MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\Action\Context $context)
    {
        $this->getChangelogEntries = $getChangelogEntries;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    public function execute(){

        $mode = $this->getRequest()->getParam('mode');

        $searchCriteria = $this->searchCriteriaBuilder
            ->addSortOrder('version_date', 'desc')
            ->create();

        $entries = $this->getChangelogEntries->execute($searchCriteria, $mode);

        $result = $this->jsonResultFactory->create();
        $result->setData($entries);
        return $result;
    }
}
