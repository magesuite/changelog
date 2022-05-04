<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api\Data;

interface ChangelogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Changelog list.
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface[]
     */
    public function getItems(): array;

    /**
     * Set version list.
     * @param \MageSuite\Changelog\Api\Data\ChangelogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
