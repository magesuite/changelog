<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model\Data;

class Deployment extends \Magento\Framework\Api\AbstractExtensibleObject implements \MageSuite\Changelog\Api\Data\DeploymentInterface
{

    public function getDeploymentId()
    {
        return $this->_get(self::DEPLOYMENT_ID);
    }

    public function setDeploymentId($deploymentId)
    {
        return $this->setData(self::DEPLOYMENT_ID, $deploymentId);
    }

    public function getDeployedAt()
    {
        return $this->_get(self::DEPLOYED_AT);
    }

    public function setDeployedAt($deployedAt)
    {
        return $this->setData(self::DEPLOYED_AT, $deployedAt);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(
        \MageSuite\Changelog\Api\Data\DeploymentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
