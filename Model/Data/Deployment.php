<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageSuite\Changelog\Model\Data;

use MageSuite\Changelog\Api\Data\DeploymentInterface;

class Deployment extends \Magento\Framework\Api\AbstractExtensibleObject implements DeploymentInterface
{

    /**
     * Get deployment_id
     * @return string|null
     */
    public function getDeploymentId()
    {
        return $this->_get(self::DEPLOYMENT_ID);
    }

    /**
     * Set deployment_id
     * @param string $deploymentId
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     */
    public function setDeploymentId($deploymentId)
    {
        return $this->setData(self::DEPLOYMENT_ID, $deploymentId);
    }

    /**
     * Get deployed_at
     * @return string|null
     */
    public function getDeployedAt()
    {
        return $this->_get(self::DEPLOYED_AT);
    }

    /**
     * Set deployed_at
     * @param string $deployedAt
     * @return \MageSuite\Changelog\Api\Data\DeploymentInterface
     */
    public function setDeployedAt($deployedAt)
    {
        return $this->setData(self::DEPLOYED_AT, $deployedAt);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

