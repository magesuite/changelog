<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Get extends \MageSuite\Changelog\Controller\Adminhtml\Changelog\AbstractChangelogAction
{

    public function execute()
    {

        $entries = $this->getEntries();

        $result = $this->jsonResultFactory->create();
        $result->setData($entries);

        return $result;
    }
}
