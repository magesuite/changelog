<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api;

interface ChangelogRepositoryInterface
{

    /**
     * @param \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    );

    /**
     * @param string $changelogId
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($changelogId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MageSuite\Changelog\Api\Data\ChangelogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * @param \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MageSuite\Changelog\Api\Data\ChangelogInterface $changelog
    );

    /**
     * @param string $changelogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($changelogId);
}
