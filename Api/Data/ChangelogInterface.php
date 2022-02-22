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
     * Get changelog_id
     * @return string|null
     */
    public function getChangelogId();

    /**
     * Set changelog_id
     * @param string $changelogId
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangelogId($changelogId);

    /**
     * Get version
     * @return string|null
     */
    public function getVersion();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setVersion($version);

    /**
     * Get version
     * @return string|null
     */
    public function getUrl();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setUrl($url);

    /**
     * Get version
     * @return string|null
     */
    public function getModule();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setModule($module);

    /**
     * Get version
     * @return string|null
     */
    public function getDescription();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setDescription($description);

    /**
     * Get version
     * @return string|null
     */
    public function getTicketId();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setTicketId($ticketId);

    /**
     * Get version
     * @return string|null
     */
    public function getVersionDate();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setVersionDate($versionDate);

    /**
     * Get version
     * @return string|null
     */
    public function getChangeType();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeType($changeType);

    /**
     * Get version
     * @return string|null
     */
    public function getChangeOverview();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeOverview($version);

    /**
     * Get version
     * @return string|null
     */
    public function getChangeDescription();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeDescription($changeDescription);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MageSuite\Changelog\Api\Data\ChangelogExtensionInterface|null
     */

    /**
     * Get version
     * @return string|null
     */
    public function getChangeUrl();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setChangeUrl($changeUrl);

    /**
     * Get version
     * @return string|null
     */
    public function getHighlighted();

    /**
     * Set version
     * @param string $version
     * @return \MageSuite\Changelog\Api\Data\ChangelogInterface
     */
    public function setHighlighted($highlighted);


}

