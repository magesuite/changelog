<?php

namespace MageSuite\Changelog\Config\Changelog;

class Data
{
    // phpcs:ignore
    protected $_dataStorage;

    /**
     * @param \Magento\Framework\Config\DataInterface $dataStorage
     */
    public function __construct(\Magento\Framework\Config\Data $dataStorage)
    {
        $this->_dataStorage = $dataStorage;
    }

    public function getData()
    {
        return $this->_dataStorage->get('module', []);
    }
}
