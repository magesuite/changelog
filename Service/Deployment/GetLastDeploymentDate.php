<?php

namespace MageSuite\Changelog\Service\Deployment;

class GetLastDeploymentDate
{

    protected $deploymentRepository;

    public function __construct(
        \MageSuite\Changelog\Model\DeploymentRepository $deploymentRepository
    ) {
        $this->deploymentRepository = $deploymentRepository;
    }

    public function execute()
    {
        $deployment = $this->deploymentRepository->getLastDeployment();
        return $deployment->getDeployedAt();
    }
}
