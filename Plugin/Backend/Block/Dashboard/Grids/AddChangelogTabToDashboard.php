<?php

namespace MageSuite\Changelog\Plugin\Backend\Block\Dashboard\Grids;

class AddChangelogTabToDashboard extends \Magento\Backend\Block\Dashboard\Grids
{
    protected function _prepareLayout() // @codingStandardsIgnoreLine - required by parent class
    {
        parent::_prepareLayout();

        $this->addTab(
            'changelog',
            [
                'label'     => __('Changelog'),
                'url'       => $this->getUrl('changelog/dashboard/changelog', ['_current' => true]),
                'class'     => 'ajax',
                'active'    => false
            ]
        );
    }
}
