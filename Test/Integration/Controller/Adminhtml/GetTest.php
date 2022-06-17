<?php
namespace Magesuite\Changelog\Test\Integration\Controller\Adminhtml;

class GetTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{
    protected $addChangelogEntriesToDatabase;
    protected $cacheTypeList;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->addChangelogEntriesToDatabase = $this->objectManager->get(\MageSuite\Changelog\Service\AddChangelogEntriesToDatabase::class);
        $this->cacheTypeList = $this->objectManager->get(\Magento\Framework\App\Cache\TypeListInterface::class);

        parent::setUp();
    }

    private function fetchChangelogEntries($params)
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
    public function testItFetchesChangelogEntriesAsJson()
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
     * @magentoDataFixture copyDummyChangelog
     */
    public function testItFetchesChangelogEntriesFromOtherExtensions()
    {
        $getData = [
            'mode' => 'grouped',
            'from' => '2000-05-01',
            'to' => '2022-06-15',
            'isAjax' => 'true'
        ];

        $this->cacheTypeList->cleanType('config');
        $this->addChangelogEntriesToDatabase->execute();
        $entries = json_decode($this->fetchChangelogEntries($getData), true);
        $this->assertArrayHasKey('Module_Dummy', $entries);
        $this->assertArrayHasKey('1.0.0', $entries['Module_Dummy']);

        $this->assertArrayHasKey('change_overview', $entries['Module_Dummy']['1.0.0'][0]);
        $this->assertEquals('Initial release of dummy changelog', $entries['Module_Dummy']['1.0.0'][0]['change_overview']);
    }

    public static function copyDummyChangelog()
    {
        require __DIR__ . '/../../_files/copy_changelog.php';
    }

    public static function copyDummyChangelogRollback()
    {
        require __DIR__ . '/../../_files/copy_changelog_rollback.php';
    }
}
