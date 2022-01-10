<?php

namespace MageSuite\Changelog\Test\Integration\Config\Changelog;

class ConverterTest extends \PHPUnit\Framework\TestCase
{

    protected $converter;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->converter = $this->objectManager->create(\MageSuite\Changelog\Config\Changelog\Converter::class);
    }
    public function testItConvertsXmlCorrectly(){


    }
}
