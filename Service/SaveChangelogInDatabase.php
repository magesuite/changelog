<?php

namespace MageSuite\Changelog\Service;

class SaveChangelogInDatabase
{

    protected $resourceConnection;
    protected $connection;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->connection = $resourceConnection->getConnection();
    }

    public function execute($flattenedChangelog)
    {
        $this->clearChangelogTable();
        $this->insertDataToDatabase($flattenedChangelog);
    }

    private function clearChangelogTable()
    {
        $table = $this->connection->getTableName('changelog_entity');
        $query = $this->connection->delete($table);
    }

    private function insertDataToDatabase($flattenedChangelog)
    {
        $table = $this->connection->getTableName('changelog_entity');
        $query = $this->connection->insertMultiple($table, $flattenedChangelog);
    }
}
