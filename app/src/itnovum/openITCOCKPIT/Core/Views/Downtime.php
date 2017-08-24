<?php
// Copyright (C) <2015>  <it-novum GmbH>
//
// This file is dual licensed
//
// 1.
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, version 3 of the License.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// 2.
//  If you purchased an openITCOCKPIT Enterprise Edition you can use this file
//  under the terms of the openITCOCKPIT Enterprise Edition license agreement.
//  License agreement and license key will be shipped with the order
//  confirmation.

namespace itnovum\openITCOCKPIT\Core\Views;


class Downtime {

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $commentData;

    /**
     * @var int|string
     */
    private $entryTime;

    /**
     * @var int|string
     */
    private $scheduledStartTime;

    /**
     * @var int|string
     */
    private $scheduledEndTime;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var bool
     */
    private $wasStarted;

    /**
     * @var int
     */
    private $internalDowntimeId;

    /**
     * @var int
     */
    private $downtimehistoryId;

    /**
     * @var bool
     */
    private $wasCancelled;


    public function __construct($downtime) {
        if (isset($downtime['author_name'])) {
            $this->authorName = $downtime['author_name'];
        }

        if (isset($downtime['comment_data'])) {
            $this->commentData = $downtime['comment_data'];
        }

        if (isset($downtime['entry_time'])) {
            $this->entryTime = $downtime['entry_time'];
        }

        if (isset($downtime['scheduled_start_time'])) {
            $this->scheduledStartTime = $downtime['scheduled_start_time'];
        }

        if (isset($downtime['scheduled_end_time'])) {
            $this->scheduledEndTime = $downtime['scheduled_end_time'];
        }

        if (isset($downtime['duration'])) {
            $this->duration = (int)$downtime['duration'];
        }

        if (isset($downtime['was_started'])) {
            $this->wasStarted = (bool)$downtime['was_started'];
        }

        if (isset($downtime['internal_downtime_id'])) {
            $this->internalDowntimeId = (int)$downtime['internal_downtime_id'];
        }

        if (isset($downtime['downtimehistory_id'])) {
            $this->downtimehistoryId = (int)$downtime['downtimehistory_id'];
        }

        if (isset($downtime['was_cancelled'])) {
            $this->wasCancelled = (bool)$downtime['was_cancelled'];
        }
    }

    /**
     * @return string
     */
    public function getAuthorName() {
        return $this->authorName;
    }

    /**
     * @return string
     */
    public function getCommentData() {
        return $this->commentData;
    }

    /**
     * @return int
     */
    public function getEntryTime() {
        if (!is_numeric($this->entryTime)) {
            return strtotime($this->entryTime);
        }
        return $this->entryTime;
    }

    /**
     * @return int
     */
    public function getScheduledStartTime() {
        if (!is_numeric($this->scheduledStartTime)) {
            return strtotime($this->scheduledStartTime);
        }
        return $this->scheduledStartTime;
    }

    /**
     * @return int
     */
    public function getScheduledEndTime() {
        if (!is_numeric($this->scheduledEndTime)) {
            return strtotime($this->scheduledEndTime);
        }
        return $this->scheduledEndTime;
    }

    /**
     * @return int
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @return bool
     */
    public function wasStarted() {
        return $this->wasStarted;
    }

    /**
     * @return int
     */
    public function getInternalDowntimeId() {
        return $this->internalDowntimeId;
    }

    /**
     * @return int
     */
    public function getDowntimehistoryId() {
        return $this->downtimehistoryId;
    }

    /**
     * @return bool
     */
    public function wasCancelled() {
        return $this->wasCancelled;
    }

    /**
     * @return bool
     */
    public function isCancellable() {
        return $this->getScheduledEndTime() > time() && $this->wasCancelled === false;
    }

    /**
     * @return bool
     */
    public function isRunning() {
        if ($this->wasStarted() === true && $this->isCancellable()) {
            return true;
        }
        return false;
    }

    public function isExpired() {
        if ($this->wasStarted() && $this->getScheduledEndTime() < time() && $this->wasCancelled() === false) {
            return true;
        }
        return false;
    }

}