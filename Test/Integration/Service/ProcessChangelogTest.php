<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Test\Integration\Service;

class ProcessChangelogTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;
    protected ?\MageSuite\Changelog\Model\ChangelogRepository $changelogRepository;
    protected ?\MageSuite\Changelog\Model\DeploymentRepository $deploymentRepository;

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
