<?php

namespace MageSuite\Changelog\Service\Deployment;

class CreateDeploymentMarker
{

    protected \MageSuite\Changelog\Model\DeploymentRepository $deploymentRepository;

    protected \MageSuite\Changelog\Model\DeploymentFactory $deploymentFactory;

    protected \Magento\Framework\Stdlib\DateTime\DateTime $dateTime;

    public function __construct(
        \MageSuite\Changelog\Model\DeploymentRepository $deploymentRepository,
        \MageSuite\Changelog\Model\DeploymentFactory $deploymentFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->deploymentRepository = $deploymentRepository;
        $this->deploymentFactory = $deploymentFactory;
        $this->dateTime = $dateTime;
    }

    public function execute($date = null)
    {
        $deployment = $this->deploymentFactory->create();
        $deployment->setDeployedAt($date ?: $this->dateTime->gmtDate('Y-m-d h:i:s'));

        try {
            return $deployment->save();
            // phpcs:ignore
        } catch (\Exception $exception) {
            // be verbose
        }
    }
}
