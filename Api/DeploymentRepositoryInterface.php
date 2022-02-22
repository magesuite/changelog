<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DeploymentRepositoryInterface
{

    /**
     * Save Deployment
     * @param \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
    );

    /**
     * Retrieve Deployment
     * @param string $deploymentId
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($deploymentId);

    /**
     * Retrieve Deployment matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MageSuite\Changelog\Api\Data\DeploymentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Deployment
     * @param \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MageSuite\Changelog\Api\Data\DeploymentInterface $deployment
    );

    /**
     * Delete Deployment by ID
     * @param string $deploymentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($deploymentId);
}

