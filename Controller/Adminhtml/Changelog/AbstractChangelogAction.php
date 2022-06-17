<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

abstract class AbstractChangelogAction extends \Magento\Backend\App\Action
{
    protected \MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries;

    const ADMIN_RESOURCE = 'MageSuite_Changelog::Changelog';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->getChangelogEntries = $getChangelogEntries;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->resultRawFactory = $resultRawFactory;

        parent::__construct($context);
    }

    protected \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory;
    protected \Magento\Framework\Api\FilterBuilder $filterBuilder;
    protected \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder;
    protected \Magento\Framework\Controller\Result\RawFactory $resultRawFactory;

    protected function getEntries()
    {

        $mode = $this->getRequest()->getParam('mode');
        $params = $this->parseParams();
        $filters = $this->buildFilters($params['from'], $params['to']);
        $searchCriteria = $this->buildCriterias($filters);

        return $this->getChangelogEntries->execute($searchCriteria, $mode);
    }

    protected function buildFilters($from, $to): array
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

    protected function parseParams(): array
    {
        $from = $this->getRequest()->getParam('from') ?: '2000-01-01';
        $to = $this->getRequest()->getParam('to') ?: date('Y-m-d');

        return [
            'from' => $from,
            'to' => $to
        ];
    }

    protected function buildCriterias($filters): \Magento\Framework\Api\Search\SearchCriteria
    {
        return $this->searchCriteriaBuilder
            ->addFilter($filters['from'])
            ->addFilter($filters['to'])
            ->addSortOrder('version_date', 'desc')
            ->create();
    }
}
