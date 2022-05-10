<?php

namespace MageSuite\Changelog\Setup;

class Recurring implements \Magento\Framework\Setup\InstallSchemaInterface
{
    protected \MageSuite\Changelog\Service\AddChangelogEntriesToDatabase $addChangelogEntriesToDatabase;
    protected $createDeploymentMarker;

    public function __construct(
        \MageSuite\Changelog\Service\AddChangelogEntriesToDatabase $addChangelogEntriesToDatabase,
        \MageSuite\Changelog\Service\Deployment\CreateDeploymentMarker $createDeploymentMarker
    ) {
        $this->addChangelogEntriesToDatabase = $addChangelogEntriesToDatabase;
        $this->createDeploymentMarker = $createDeploymentMarker;
    }

    /**
     * {@inheritdoc}
     */
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $this->addChangelogEntriesToDatabase->execute();
        $this->createDeploymentMarker->execute();
    }
}
