<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Model\Data;

use MageSuite\Changelog\Api\Data\ChangelogInterface;

class Changelog extends \Magento\Framework\Api\AbstractSimpleObject implements ChangelogInterface
{

    public function getChangelogId()
    {
        return $this->_get(self::CHANGELOG_ID);
    }

    public function setChangelogId($changelogId)
    {
        return $this->setData(self::CHANGELOG_ID, $changelogId);
    }

    public function getVersion()
    {
        return $this->_get(self::VERSION);
    }

    public function setModule($module)
    {
        return $this->setData(self::MODULE, $module);
    }


    public function getModule()
    {
        return $this->_get(self::MODULE);
    }

    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }


    public function setTicketId($ticketId)
    {
        return $this->setData(self::TICKET_ID, $ticketId);
    }

    /**
     * @return mixed|string|null
     */
    public function getTicketId()
    {
        return $this->_get(self::TICKET_ID);
    }

    /**
     * @param $url
     * @return ChangelogInterface|Changelog
     */
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * @return mixed|string|null
     */
    public function getUrl()
    {
        return $this->_get(self::URL);
    }

    /**
     * @param $versionDate
     * @return ChangelogInterface|Changelog
     */
    public function setVersionDate($versionDate)
    {
        return $this->setData(self::VERSION_DATE, $versionDate);
    }

    /**
     * @return mixed|string|null
     */
    public function getVersionDate()
    {
        return $this->_get(self::VERSION_DATE);
    }

    /**
     * @param $changeType
     * @return ChangelogInterface|Changelog
     */
    public function setChangeType($changeType)
    {
        return $this->setData(self::CHANGE_TYPE, $changeType);
    }

    /**
     * @return mixed|string|null
     */
    public function getChangeType()
    {
        return $this->_get(self::CHANGE_TYPE);
    }

    /**
     * @param string $changeOverview
     * @return ChangelogInterface|Changelog
     */
    public function setChangeOverview($changeOverview)
    {
        return $this->setData(self::CHANGE_OVERVIEW, $changeOverview);
    }

    /**
     * @return mixed|string|null
     */
    public function getChangeOverview()
    {
        return $this->_get(self::CHANGE_OVERVIEW);
    }

    /**
     * @param $changeOverview
     * @return ChangelogInterface|Changelog
     */
    public function setChangeDescription($changeOverview)
    {
        return $this->setData(self::CHANGE_DESCRIPTION, $changeOverview);
    }

    /**
     * @return mixed|string|null
     */
    public function getChangeDescription()
    {
        return $this->_get(self::CHANGE_DESCRIPTION);
    }

    /**
     * @param $changeUrl
     * @return ChangelogInterface|Changelog
     */
    public function setChangeUrl($changeUrl)
    {
        return $this->setData(self::CHANGE_URL, $changeUrl);
    }

    /**
     * @return mixed|string|null
     */
    public function getChangeUrl()
    {
        return $this->_get(self::CHANGE_URL);
    }

    public function getHighlighted(): mixed
    {
        return $this->_get(self::HIGHLIGHTED);
    }

    public function setHighlighted($highlighted)
    {
        return $this->setData(self::HIGHLIGHTED, $highlighted);
    }

    public function setVersion($version)
    {
        return $this->setData(self::VERSION, $version);
    }

    public function getData(): array
    {
        return $this->_data;
    }
}
