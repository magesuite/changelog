<?php
namespace Magesuite\Changelog\Test\Integration\Controller\Adminhtml;

class PreviewControllerTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{

    public function testItRendersHtmlContentCorrectly()
    {
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPostValue(['filename' => '02_adding_markown_descriptions']);
        $this->dispatch('backend/changelog/changelog/preview');

        $result = str_replace("\n", "\n", $this->getResponse()->getBody());

        $this->assertStringEqualsFile(__DIR__ . '/../../_files/parsed_markdown.html', $result);
    }
}
