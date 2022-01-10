<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Dashboard;

class Changelog extends \Magento\Backend\Controller\Adminhtml\Dashboard\AjaxBlock
{

    public function execute()
    {
        $output = $this->layoutFactory->create()
            ->createBlock('MageSuite\Changelog\Block\Adminhtml\Dashboard\Changelog')
            ->setName('changelog')
            ->toHtml();

        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents($output);
    }
}
