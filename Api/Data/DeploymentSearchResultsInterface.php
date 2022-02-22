<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api\Data;

interface DeploymentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Deployment list.
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface[]
     */
    public function getItems();

    /**
     * Set deployed_at list.
     * @param \MageSuite\Changelog\Api\Data\DeploymentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

