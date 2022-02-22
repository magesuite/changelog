<?php

namespace MageSuite\Changelog\Test\Integration\Config;

class DataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \MageSuite\Changelog\Service\ProcessChangelog
     */
    private $processChangelog;

    private $changelogRepository;

    private $deploymentRepository;

    private $data;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->processChangelog = $this->objectManager->get(\MageSuite\Changelog\Service\ProcessChangelog::class);
        $this->changelogRepository = $this->objectManager->get(\MageSuite\Changelog\Model\ChangelogRepository::class);
        $this->deploymentRepository = $this->objectManager->get(\MageSuite\Changelog\Model\DeploymentRepository::class);
        $this->data = $this->objectManager->get(\MageSuite\Changelog\Config\Changelog\Data::class);
    }

    public function testItReadsDataFromXmlsCorrectly(){
        $data = $this->data->getData();
        $this->assertArrayHasKey('MageSuite_Changelog', $data, 'Failed to assert that changelog.xml was read properly.');
        $this->assertArrayHasKey('id', $data['MageSuite_Changelog']);
        $this->assertIsArray($data['MageSuite_Changelog']['tags'], 'Failed to assert that tags were read properly');

    }

}
