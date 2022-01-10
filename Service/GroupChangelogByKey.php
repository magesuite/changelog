<?php

namespace MageSuite\Changelog\Service;

class GroupChangelogByKey{

    public function execute($changelog, $key = 'module'){
        $result = [];
        foreach($changelog as $entry){
            $result[$entry[$key]][$entry['version']][] = $entry;
        }

        return $result;
    }
}
