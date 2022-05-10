<?php

namespace MageSuite\Changelog\Test\Integration\Service;

class ProcessChangelogTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \MageSuite\Changelog\Model\ChangelogRepository
     */
    private $changelogRepository;

    /**
     * @var \MageSuite\Changelog\Model\DeploymentRepository
     */
    private $deploymentRepository;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->changelogRepository = $this->objectManager->get(\MageSuite\Changelog\Model\ChangelogRepository::class);
        $this->deploymentRepository = $this->objectManager->get(\MageSuite\Changelog\Model\DeploymentRepository::class);
    }

    public function testItGeneratedChangelogEntitesUponInstallation()
    {
        $entries = $this->changelogRepository->getList();
        $this->assertGreaterThan(0, $entries->getTotalCount());
    }

    public function testItCreatedDeploymentMarkUponInstallation()
    {
        $entries = $this->deploymentRepository->getList();
        $this->assertGreaterThanOrEqual(1, $entries->getTotalCount());
    }
}
