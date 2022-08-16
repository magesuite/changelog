<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model;

class CustomChangelogPathsPool
{
    protected $customChangelogPaths = [];

    public function __construct($customChangelogPaths)
    {
        $this->customChangelogPaths = $customChangelogPaths;
    }

    public function get(): array
    {
        return $this->customChangelogPaths;
    }
}
