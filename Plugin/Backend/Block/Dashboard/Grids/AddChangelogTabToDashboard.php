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
                'content'   => $this->getLayout()->createBlock(\MageSuite\Changelog\Block\Adminhtml\Dashboard\Changelog::class)->toHtml(),
                'active'    => true,
            ]
        );
    }
}
