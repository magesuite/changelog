<?php

namespace MageSuite\Changelog\Block\Adminhtml\Dashboard;

class Changelog extends \Magento\Backend\Block\Template
{

    protected \MageSuite\Changelog\Helper\Configuration $configuration;

    protected \MageSuite\Changelog\Service\Deployment\GetLastDeploymentDate $getLastDeploymentDate;

    public function __construct(
        \MageSuite\Changelog\Helper\Configuration $configuration,
        \Magento\Backend\Block\Template\Context $context,
        \MageSuite\Changelog\Service\Deployment\GetLastDeploymentDate $getLastDeploymentDate,
        array $data = []
    ) {
        $this->configuration = $configuration;
        $this->getLastDeploymentDate = $getLastDeploymentDate;
        $this->_template = 'MageSuite_Changelog::dashboard/changelog.phtml';
        parent::__construct($context, $data);
    }


    public function getTrackerUrl()
    {
        return $this->configuration->getTrackerUrl();
    }

    public function getDateOfLastDeployment(): ?string
    {
        return $this->getLastDeploymentDate->execute();
    }
}
