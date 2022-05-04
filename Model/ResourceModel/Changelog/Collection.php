<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model\ResourceModel\Changelog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    // phpcs:ignore
    protected $_idFieldName = 'changelog_id';

    protected function _construct()
    {
        $this->_init(
            \MageSuite\Changelog\Model\Changelog::class,
            \MageSuite\Changelog\Model\ResourceModel\Changelog::class
        );
    }

    // phpcs:ignore
    protected function _initSelect()
    {
        parent::_initSelect();
    }
}
