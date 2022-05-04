<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Api\Data;

interface ChangelogInterface
{
    const VERSION = 'version';
    const CHANGELOG_ID = 'changelog_id';
    const URL = 'url';
    const MODULE = 'module';
    const DESCRIPTION = 'description';
    const TICKET_ID = 'ticket_id';
    const VERSION_DATE = 'version_date';
    const CHANGE_TYPE = 'change_type';
    const CHANGE_OVERVIEW = 'change_overview';
    const CHANGE_DESCRIPTION = 'change_description';
    const CHANGE_URL = 'change_url';
    const HIGHLIGHTED = 'highlihgted';

    /**
     * @return string|null
     */
    public function getChangelogId();

    /**
     * @param string $changelogId
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangelogId($changelogId);

    /**
     * @return string|null
     */
    public function getVersion();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setVersion($version);

    /**
     * @return string|null
     */
    public function getUrl();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setUrl($url);

    /**
     * @return string|null
     */
    public function getModule();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setModule($module);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setDescription($description);

    /**
     * @return string|null
     */
    public function getTicketId();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setTicketId($ticketId);

    /**
     * @return string|null
     */
    public function getVersionDate();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setVersionDate($versionDate);

    /**
     * @return string|null
     */
    public function getChangeType();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeType($changeType);

    /**
     * @return string|null
     */
    public function getChangeOverview();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeOverview($version);

    /**
     * @return string|null
     */
    public function getChangeDescription();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeDescription($changeDescription);

    /**
     * @return string|null
     */
    public function getChangeUrl();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeUrl($changeUrl);

    /**
     * @return string|null
     */
    public function getHighlighted();

    /**
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setHighlighted($highlighted);
}
