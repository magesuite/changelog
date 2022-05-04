<?php

namespace MageSuite\Changelog\Test\Integration\Service;

class CreateDeploymentMarkerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    private $objectManager;

    /**
     * @var mixed
     */
    private $createDeploymentMarker;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->createDeploymentMarker = $this->objectManager->get(\MageSuite\Changelog\Service\Deployment\CreateDeploymentMarker::class);
    }

    public function testItCreatesNewDeploymentMarkerCorrectly()
    {
        $imaginaryDeploymentDate = '1983-09-21 01:00:00';
        $newDeploymentMarker = $this->createDeploymentMarker->execute($imaginaryDeploymentDate);
        $this->assertGreaterThan(1, $newDeploymentMarker->getId());
        $this->assertEquals($imaginaryDeploymentDate, $newDeploymentMarker->getData(\MageSuite\Changelog\Api\Data\DeploymentInterface::DEPLOYED_AT));
    }
}
