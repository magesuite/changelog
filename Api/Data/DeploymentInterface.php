<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api\Data;

interface DeploymentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    public const DEPLOYED_AT = 'deployed_at';
    public const DEPLOYMENT_ID = 'deployment_id';

    /**
     * Get deployment_id
     * @return string|null
     */
    public function getDeploymentId();

    /**
     * Set deployment_id
     * @param string $deploymentId
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     */
    public function setDeploymentId($deploymentId);

    /**
     * Get deployed_at
     * @return string|null
     */
    public function getDeployedAt();

    /**
     * Set deployed_at
     * @param string $deployedAt
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     */
    public function setDeployedAt($deployedAt);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface $extensionAttributes
    );
}

