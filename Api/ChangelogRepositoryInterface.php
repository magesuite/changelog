<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChangelogRepositoryInterface
{

    /**
     * Save Changelog
     * @param \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    );

    /**
     * Retrieve Changelog
     * @param string $changelogId
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($changelogId);

    /**
     * Retrieve Changelog matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MageSuite\Changelog\Api\Data\ChangelogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Changelog
     * @param \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    );

    /**
     * Delete Changelog by ID
     * @param string $changelogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($changelogId);
}

