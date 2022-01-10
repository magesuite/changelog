<?php

namespace MageSuite\Changelog\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_ENABLED = 'changelog/general/enabled';
    public const XML_PATH_TRACKER_URL = 'changelog/general/tracker_url';

    public function isEnabled(){
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getTrackerUrl(){
        return $this->scopeConfig->getValue(self::XML_PATH_TRACKER_URL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getConfigurationForKey($key){
        return $this->scopeConfig->getValue('changelog/general/'.$key, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
