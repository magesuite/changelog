<?php

namespace MageSuite\Changelog\Service;

class FlattenChangelog {


    public function execute($changelogData){
        $entries = [];

        foreach($changelogData as $moduleName => $changlogEntry){
            $entry['module'] = $moduleName;
            $entry['description'] = $changlogEntry['description'];
            $entry['url'] = $changlogEntry['url'];
            foreach($changlogEntry['tags'] as $tag){
                $entry['version'] = $tag['version'];
                $entry['version_date'] = $tag['date'];
                foreach($tag['changes'] as $change){
                    $entry['change_type'] = $change['type'];
                    $entry['change_overview'] = $change['overview'];
                    $entry['change_description'] = $tag['description'] ?? '';
                    $entry['change_url'] = $change['url'] ?? '';
                    $entry['ticket_id'] = $change['ticket_id'] ?? '';
                    $entry['highlighted'] = $change['highlighted'] ?? '0';

                    $entries[] = $entry;
                }
            }
        }

        return $entries;
    }
}