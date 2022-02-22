<?php

namespace MageSuite\Changelog\Test\Integration\Service;

class GetChangelogEntriesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \MageSuite\Changelog\Service\ProcessChangelog
     */
    private $processChangelog;

    private $getChangelogEntries;


    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->processChangelog = $this->objectManager->get(\MageSuite\Changelog\Service\ProcessChangelog::class);
        $this->getChangelogEntries = $this->objectManager->get(\MageSuite\Changelog\Service\GetChangelogEntries::class);
    }


    public function testItGetsChangelogDataInGroupedModeCorrectly()
    {
       $entries = $this->getChangelogEntries->execute(null, 'grouped');
       $this->assertIsArray($entries);
       $this->assertArrayHasKey('MageSuite_Changelog', $entries);
    }

    public function testItGetsChangelogDataInTimelineModeCorrectly()
    {
        $entries = $this->getChangelogEntries->execute(null, null);
        $this->assertIsArray($entries);
        $this->assertEquals('MageSuite_Changelog', $entries[0]['module']);
    }

}
