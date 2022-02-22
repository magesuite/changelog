<?php

namespace MageSuite\Changelog\Service;

class ProcessChangelog
{

    protected $data;

    protected $flattenChangelog;

    protected $saveChangelogInDatabase;

    public function __construct(
        \MageSuite\Changelog\Config\Changelog\Data $data,
        \MageSuite\Changelog\Service\FlattenChangelog $flattenChangelog,
        \MageSuite\Changelog\Service\SaveChangelogInDatabase $saveChangelogInDatabase
    ) {
        $this->data = $data;
        $this->flattenChangelog = $flattenChangelog;
        $this->saveChangelogInDatabase = $saveChangelogInDatabase;
    }

    public function execute()
    {
        $changelogEntries = $this->data->getData();
        $flattenedChangelog = $this->flattenChangelog->execute($changelogEntries);
        $this->saveChangelogInDatabase->execute($flattenedChangelog);
    }
}
