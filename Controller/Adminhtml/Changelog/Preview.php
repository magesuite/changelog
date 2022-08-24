<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Preview extends \MageSuite\Changelog\Controller\Adminhtml\Changelog\AbstractChangelogAction implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public function execute()
    {
        $reference = $this->getRequest()->getPostValue('filename');
        if (empty($reference)) {
            return $this;
        }

        $filename =  $this->getFilename($reference);
        // phpcs:ignore
        $parsedContent = $this->parseDown->toHtml(file_get_contents($filename))."\n";

        $result = $this->resultRawFactory->create();
        $result->setContents($parsedContent);

        return $result;
    }

    protected function getFilename($docReference): string
    {
        return sprintf('%s/../../../doc/%s.MD', __DIR__, $docReference);
    }
}
