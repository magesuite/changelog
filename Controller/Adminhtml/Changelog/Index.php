<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Index extends \MageSuite\Changelog\Controller\Adminhtml\Changelog\AbstractChangelogAction
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
