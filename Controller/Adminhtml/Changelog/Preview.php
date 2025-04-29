<?php

namespace MageSuite\Changelog\Controller\Adminhtml\Changelog;

class Preview extends \MageSuite\Changelog\Controller\Adminhtml\Changelog\AbstractChangelogAction implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public function execute()
    {
        $reference = $this->getRequest()->getPostValue('filename');

        if (empty($reference) || !preg_match('/^[a-zA-Z0-9_\-]+$/', $reference)) {
            return $this;
        }

        $filename = $this->getFilename($reference);
        $result = $this->resultRawFactory->create();
        // phpcs:ignore
        if (file_exists($filename)) {
            $result->setContents(nl2br(htmlspecialchars(file_get_contents($filename))));
        }

        return $result;
    }

    protected function getFilename(string $docReference): string
    {
        return sprintf('%s/../../../doc/%s.MD', __DIR__, $docReference);
    }
}
