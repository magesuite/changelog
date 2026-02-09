<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Test\Integration\Service;

class GetChangelogEntriesTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;
    protected ?\MageSuite\Changelog\Service\GetChangelogEntries $getChangelogEntries;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->getChangelogEntries = $this->objectManager->get(\MageSuite\Changelog\Service\GetChangelogEntries::class);
    }

    public function testItGetsChangelogDataInGroupedModeCorrectly()
    {
        $entries = $this->getChangelogEntries->execute(null, 'grouped');
        $this->assertIsArray($entries);
        $this->assertArrayHasKey('MageSuite_Changelog', $entries);
        $this->assertArrayHasKey('MageSuite_Patches', $entries);
    }

    public function testItGetsChangelogDataInTimelineModeCorrectly()
    {
        $entries = $this->getChangelogEntries->execute(null, null);
        $this->assertIsArray($entries);

        $changelogEntryFound = false;
        foreach ($entries as $entry) {
            if ($entry['module']=='MageSuite_Changelog') {
                $changelogEntryFound = true;
            }
        }

        $this->assertEquals(true, $changelogEntryFound);
    }
}
