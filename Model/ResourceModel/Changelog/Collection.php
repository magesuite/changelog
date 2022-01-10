<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model\ResourceModel\Changelog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'changelog_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \MageSuite\Changelog\Model\Changelog::class,
            \MageSuite\Changelog\Model\ResourceModel\Changelog::class
        );
    }
}

