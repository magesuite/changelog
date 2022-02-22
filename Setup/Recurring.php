<?php

namespace MageSuite\Changelog\Setup;

use Magento\Framework\Encryption\Encryptor;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Indexer\StateInterface;
use Magento\Framework\Json\EncoderInterface;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Indexer\ConfigInterface;
use Magento\Indexer\Model\Indexer\State;
use Magento\Indexer\Model\Indexer\StateFactory;
use Magento\Indexer\Model\ResourceModel\Indexer\State\CollectionFactory;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Recurring implements \Magento\Framework\Setup\InstallSchemaInterface
{
    protected $processChangelog;
    protected $createDeploymentMarker;

    public function __construct(
        \MageSuite\Changelog\Service\ProcessChangelog $processChangelog,
        \MageSuite\Changelog\Service\Deployment\CreateDeploymentMarker $createDeploymentMarker
    ) {
        $this->processChangelog = $processChangelog;
        $this->createDeploymentMarker = $createDeploymentMarker;
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->processChangelog->execute();
        ;
        $this->createDeploymentMarker->execute();
    }
}
