<?php

declare(strict_types=1);

namespace Magesuite\Changelog\Test\Integration\Controller\Adminhtml;

/**
 * @magentoAppArea adminhtml
 * @magentoDbIsolation enabled
 */
class GetTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{
    protected ?\MageSuite\Changelog\Service\AddChangelogEntriesToDatabase $addChangelogEntriesToDatabase;
    protected ?\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList;
    protected ?\Magento\Framework\Config\CacheInterface $cache;
    protected ?\Magento\Framework\App\ObjectManager $objectManager;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->addChangelogEntriesToDatabase = $this->objectManager->get(\MageSuite\Changelog\Service\AddChangelogEntriesToDatabase::class);
        $this->cacheTypeList = $this->objectManager->get(\Magento\Framework\App\Cache\TypeListInterface::class);
        $this->cache = $this->objectManager->get(\Magento\Framework\Config\CacheInterface::class);

        parent::setUp();
    }

    protected function fetchChangelogEntries(array $params): string
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParams($params);
        $this->dispatch('backend/changelog/changelog/get');

        return $this->getResponse()->getBody();
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testItFetchesChangelogEntriesAsJson(): void
    {
        $getData = [
            'mode' => 'grouped',
            'from' => '2000-05-01',
            'to' => '2022-06-15',
            'isAjax' => 'true'
        ];

        $result = $this->fetchChangelogEntries($getData);
        $resultJson = json_decode($result, true);
        $this->assertArrayHasKey('MageSuite_Changelog', $resultJson);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_Changelog::Test/Integration/_files/copy_changelog.php
     * @magentoCache all disabled
     */
    public function testItFetchesChangelogEntriesFromOtherExtensions(): void
    {
        $getData = [
            'mode' => 'grouped',
            'from' => '2000-05-01',
            'to' => '2022-06-15',
            'isAjax' => 'true'
        ];

        $this->cacheTypeList->cleanType('config');
        $this->cache->remove('magesuite_changelog');
        $this->addChangelogEntriesToDatabase->execute();
        $entries = json_decode($this->fetchChangelogEntries($getData), true);

        $this->assertArrayHasKey('Module_Dummy', $entries);
        $this->assertArrayHasKey('1.0.0', $entries['Module_Dummy']);

        $this->assertArrayHasKey('change_overview', $entries['Module_Dummy']['1.0.0'][0]);
        $this->assertEquals('Initial release of dummy changelog', $entries['Module_Dummy']['1.0.0'][0]['change_overview']);
    }
}
