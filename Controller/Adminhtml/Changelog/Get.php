<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Get extends \Magento\Framework\App\Action\Action
{

    protected \MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries;

    protected \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory;

    protected \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected \Magento\Framework\Api\FilterBuilder $filterBuilder;

    public function __construct(
        \MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->getChangelogEntries = $getChangelogEntries;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;

        parent::__construct($context);
    }

    public function execute()
    {

        $mode = $this->getRequest()->getParam('mode');
        $params = $this->parseParams();
        $filters = $this->getFilters($params['from'], $params['to']);

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter($filters['from'])
            ->addFilter($filters['to'])
            ->addSortOrder('version_date', 'desc')
            ->create();

        $entries = $this->getChangelogEntries->execute($searchCriteria, $mode);

        $result = $this->jsonResultFactory->create();
        $result->setData($entries);

        return $result;
    }

    private function getFilters($from, $to): array
    {
        $filters = [];
        $filters['from'] = $this->filterBuilder->setField('version_date')
            ->setValue($from)
            ->setConditionType('gteq')
            ->create();

        $filters['to'] = $this->filterBuilder->setField('version_date')
            ->setValue($to)
            ->setConditionType('lteq')
            ->create();

        return $filters;
    }

    private function parseParams(): array
    {
        $from = $this->getRequest()->getParam('from') ?: '2000-01-01';
        $to = $this->getRequest()->getParam('to') ?: date('Y-m-d');

        return [
          'from' => $from,
          'to' => $to
        ];
    }
}
