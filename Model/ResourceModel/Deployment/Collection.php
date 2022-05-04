<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model\ResourceModel\Deployment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    // phpcs:ignore
    protected $_idFieldName = 'deployment_id';

    protected function _construct()
    {
        $this->_init(
            \MageSuite\Changelog\Model\Deployment::class,
            \MageSuite\Changelog\Model\ResourceModel\Deployment::class
        );
    }
}
