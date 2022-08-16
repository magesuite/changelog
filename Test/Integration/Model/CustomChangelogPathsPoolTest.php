<?php

namespace MageSuite\Changelog\Test\Integration\Model;

class CustomChangelogPathsPoolTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \MageSuite\Changelog\Model\CustomChangelogPathsPool
     */
    private $customChangelogPathsPool;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->customChangelogPathsPool = $this->objectManager->get(\MageSuite\Changelog\Model\CustomChangelogPathsPool::class);
    }

    public function testItReturnsDefaultPatchesChangelogFile()
    {
        $customChangelogPaths = $this->customChangelogPathsPool->get();

        $this->assertArrayHasKey('magesuite_patches', $customChangelogPaths);
        $this->assertEquals('vendor/creativestyle/magento-patches/changelog.xml', $customChangelogPaths['magesuite_patches']);
    }
}
