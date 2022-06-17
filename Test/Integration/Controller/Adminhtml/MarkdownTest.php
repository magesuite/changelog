<?php
namespace Magesuite\Changelog\Test\Integration\Controller\Adminhtml;

class MarkdownTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{

    public function testItRendersMarkdownContentCorrectly()
    {
        $this->prepareMocks();
        $this->getRequest()->setParams(['from'=>'2000-01-01', 'to' =>'2020-12-31']);
        $this->dispatch('backend/changelog/changelog/markdown');

        $result = $this->getResponse()->getBody();

        $this->assertStringEqualsFile(__DIR__ . '/../../_files/dummy_changelog.md', $result);
    }

    private function prepareMocks()
    {
        $changelogEntriesMock = $this->getMockBuilder(\MageSuite\Changelog\Service\GetChangelogEntries::class)
            ->disableOriginalConstructor()
            ->getMock();

        $changelogEntriesMock
            ->method('execute')
            ->withAnyParameters()
            ->willReturn($this->getDummyChangelogContent());

        $this->_objectManager->addSharedInstance(
            $changelogEntriesMock,
            \MageSuite\Changelog\Service\GetChangelogEntries::class,
            true
        );
    }

    private function getDummyChangelogContent()
    {
        return [
            'MageSuite_Test' => [
                '1.0.0' => [
                    [
                        'change_type' => 'INIT',
                        'change_overview' => 'Initial release',
                        'description' => 'Dummy module'
                    ],
                    [
                        'change_type' => 'FIX',
                        'change_overview' => 'Second change within tag',
                        'description' => 'Dummy module'
                    ]
                ],
                '1.1.0' => [
                    [
                        'change_type' => 'FIX',
                        'change_overview' => 'Super important change about hreflangs.',
                        'description' => 'Dummy module'
                    ]
                ]
            ]
        ];
    }
}
