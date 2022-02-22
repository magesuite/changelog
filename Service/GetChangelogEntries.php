<?php

namespace MageSuite\Changelog\Service;

class GetChangelogEntries {

    protected $changelogRepository;

    public function __construct(
        \MageSuite\Changelog\Model\ChangelogRepository $changelogRepository
    )
    {
        $this->changelogRepository = $changelogRepository;
    }

    public function execute($criteria = null, $mode = 'grouped'): array
    {
        if($mode=='grouped') {
            $entries = $this->changelogRepository->getListAsNestedArray($criteria, $groupingKey = 'module');
        } else {
            $entries = $this->changelogRepository->getListAsTimeline($criteria, $groupingKey = 'version_date');
        }

        return $entries;
    }
}
