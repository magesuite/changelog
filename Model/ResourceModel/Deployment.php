<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model\ResourceModel;

class Deployment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('changelog_deployment', 'deployment_id');
    }
}
