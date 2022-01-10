<?php

namespace MageSuite\Changelog\Block\Adminhtml\Dashboard;

class Changelog extends \Magento\Backend\Block\Template{

    protected $configuration;

    public function __construct(
        \MageSuite\Changelog\Helper\Configuration $configuration,
        \Magento\Backend\Block\Template\Context $context,
        array $data = [])
    {
        $this->configuration = $configuration;
        $this->_template = 'MageSuite_Changelog::dashboard/changelog.phtml';
        parent::__construct($context, $data);
    }


    public function getConfiguration($key){
      return $this->configuration->getConfigurationForKey($key);
    }

}
