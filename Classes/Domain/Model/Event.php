<?php
declare(strict_types = 1);
namespace JWeiland\Events2\Domain\Model;

/*
 * This file is part of the events2 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use JWeiland\Events2\Utility\DateTimeUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This class contains all getter and setters for an Event.
 */
class Event extends AbstractEntity
{
    /**
     * @var string
     */
    protected $eventType = 'single';

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var bool
     */
    protected $topOfList = false;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $eventBegin;

    /**
     * @var \JWeiland\Events2\Domain\Model\Time
     * @cascade remove
     * @validate NotEmpty
     */
    protected $eventTime;

    /**
     * @var \DateTime
     */
    protected $eventEnd;

    /**
     * @var bool
     */
    protected $sameDay = false;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Time>
     * @cascade remove
     * @lazy
     */
    protected $multipleTimes;

    /**
     * @var int
     */
    protected $xth = 0;

    /**
     * @var int
     */
    protected $weekday = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Time>
     * @cascade remove
     * @lazy
     */
    protected $differentTimes;

    /**
     * @var int
     */
    protected $eachWeeks = 0;

    /**
     * @var int
     */
    protected $eachMonths = 0;

    /**
     * @var \DateTime
     */
    protected $recurringEnd;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Exception>
     * @cascade remove
     * @lazy
     */
    protected $exceptions;

    /**
     * @var string
     */
    protected $teaser = '';

    /**
     * @var string
     */
    protected $detailInformations = '';

    /**
     * @var bool
     */
    protected $freeEntry = false;

    /**
     * @var \JWeiland\Events2\Domain\Model\Link
     * @cascade remove
     */
    protected $ticketLink;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Category>
     * @validate NotEmpty
     * @lazy
     */
    protected $categories;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Day>
     * @cascade remove
     * @lazy
     */
    protected $days;

    /**
     * @var \JWeiland\Events2\Domain\Model\Location
     */
    protected $location;

    /**
     * @var \JWeiland\Events2\Domain\Model\Organizer
     */
    protected $organizer;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     * @lazy
     */
    protected $images;

    /**
     * @var \JWeiland\Events2\Domain\Model\Link
     * @cascade remove
     */
    protected $videoLink;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Events2\Domain\Model\Link>
     * @cascade remove
     * @lazy
     */
    protected $downloadLinks;

    /**
     * @var string
     */
    protected $importId;

    public function __construct()
    {
        $this->multipleTimes = new ObjectStorage();
        $this->differentTimes = new ObjectStorage();
        $this->exceptions = new ObjectStorage();
        $this->categories = new ObjectStorage();
        $this->days = new ObjectStorage();
        $this->images = new ObjectStorage();
        $this->downloadLinks = new ObjectStorage();
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType)
    {
        $this->eventType = $eventType;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    public function getTopOfList(): bool
    {
        return $this->topOfList;
    }

    public function setTopOfList(bool $topOfList)
    {
        $this->topOfList = $topOfList;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime|null
     */
    public function getEventBegin()
    {
        if ($this->eventBegin instanceof \DateTime) {
            if ($this->eventBegin->timezone_type !== 3) {
                $this->eventBegin->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            }
            return clone $this->eventBegin;
        } else {
            return null;
        }
    }

    public function setEventBegin(\DateTime $eventBegin = null)
    {
        $this->eventBegin = $eventBegin;
    }

    /**
     * @return Time|null
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    public function setEventTime(Time $eventTime = null)
    {
        $this->eventTime = $eventTime;
    }

    public function getDaysOfEventsTakingDays(): int
    {
        $dateTimeUtility = new DateTimeUtility();

        $eventBegin = $dateTimeUtility->standardizeDateTimeObject($this->getEventBegin());
        $eventEnd = $dateTimeUtility->standardizeDateTimeObject($this->getEventEnd());
        if (!empty($eventEnd) && $eventEnd != $eventBegin) {
            $diff = $eventBegin->diff($eventEnd);
            // Example: 20.01.2013 - 23.01.2013 = 4 days but diff shows 3. So we have to add 1 day here
            return (int)$diff->format('%a') + 1;
        } else {
            return 0;
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getEventEnd()
    {
        if ($this->eventEnd instanceof \DateTime) {
            if ($this->eventEnd->timezone_type !== 3) {
                $this->eventEnd->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            }
            return clone $this->eventEnd;
        } else {
            return null;
        }
    }

    public function setEventEnd(\DateTime $eventEnd = null)
    {
        $this->eventEnd = $eventEnd;
    }

    public function getSameDay(): bool
    {
        return $this->sameDay;
    }

    public function setSameDay(bool $sameDay)
    {
        $this->sameDay = $sameDay;
    }

    /**
     * @return ObjectStorage|Time[]
     */
    public function getMultipleTimes(): ObjectStorage
    {
        return $this->multipleTimes;
    }

    public function setMultipleTimes(ObjectStorage $multipleTimes)
    {
        $this->multipleTimes = $multipleTimes;
    }

    public function addMultipleTime(Time $multipleTime)
    {
        $this->multipleTimes->attach($multipleTime);
    }

    public function removeMultipleTime(Time $multipleTime)
    {
        $this->multipleTimes->detach($multipleTime);
    }

    public function getXth(): array
    {
        $result = [];
        $items = $GLOBALS['TCA']['tx_events2_domain_model_event']['columns']['xth']['config']['items'];
        foreach ($items as $key => $item) {
            $result[$item[1]] = $this->xth & pow(2, $key);
        }

        return $result;
    }

    public function setXth(int $xth)
    {
        $this->xth = $xth;
    }

    public function getWeekday(): array
    {
        $result = [];
        $items = $GLOBALS['TCA']['tx_events2_domain_model_event']['columns']['weekday']['config']['items'];
        foreach ($items as $key => $item) {
            $result[$item[1]] = $this->weekday & pow(2, $key);
        }

        return $result;
    }

    public function setWeekday(int $weekday)
    {
        $this->weekday = $weekday;
    }

    /**
     * @return ObjectStorage|Time[]
     */
    public function getDifferentTimes(): ObjectStorage
    {
        return $this->differentTimes;
    }

    public function setDifferentTimes(ObjectStorage $differentTimes)
    {
        $this->differentTimes = $differentTimes;
    }

    public function addDifferentTime(Time $differentTime)
    {
        $this->differentTimes->attach($differentTime);
    }

    public function removeDifferentTime(Time $differentTime)
    {
        $this->differentTimes->detach($differentTime);
    }

    public function getEachWeeks(): int
    {
        return $this->eachWeeks;
    }

    public function setEachWeeks(int $eachWeeks)
    {
        $this->eachWeeks = $eachWeeks;
    }

    public function getEachMonths(): int
    {
        return $this->eachMonths;
    }

    public function setEachMonths(int $eachMonths)
    {
        $this->eachMonths = $eachMonths;
    }

    /**
     * @return \DateTime|null
     */
    public function getRecurringEnd()
    {
        if ($this->recurringEnd instanceof \DateTime) {
            if ($this->recurringEnd->timezone_type !== 3) {
                $this->recurringEnd->setTimezone(new \DateTimeZone(date_default_timezone_get()));
            }
            return clone $this->recurringEnd;
        } else {
            return null;
        }
    }

    public function setRecurringEnd(\DateTime $recurringEnd = null)
    {
        $this->recurringEnd = $recurringEnd;
    }

    public function addException(Exception $exception)
    {
        $this->exceptions->attach($exception);
    }

    public function removeException(Exception $exception)
    {
        $this->exceptions->detach($exception);
    }

    /**
     * Returns the exceptions.
     * Additionally you can filter exceptions by type
     * Types: add, remove, time, info
     *
     * @param string $filterByType
     * @return ObjectStorage|Exception[]
     */
    public function getExceptions($filterByType = ''): ObjectStorage
    {
        $exceptions = new ObjectStorage();
        $filterByType = strtolower($filterByType);

        if (empty($filterByType)) {
            $exceptions = $this->exceptions;
        } else {
            foreach ($this->exceptions as $exception) {
                $exceptionType = strtolower($exception->getExceptionType());
                if ($exceptionType === $filterByType) {
                    $exceptions->attach($exception);
                }
            }
        }
        return $exceptions;
    }

    public function setExceptions(ObjectStorage $exceptions)
    {
        $this->exceptions = $exceptions;
    }

    public function getTeaser(): string
    {
        return $this->teaser;
    }

    public function setTeaser(string $teaser)
    {
        $this->teaser = $teaser;
    }

    public function getDetailInformations(): string
    {
        return $this->detailInformations;
    }

    public function setDetailInformations(string $detailInformations)
    {
        $this->detailInformations = $detailInformations;
    }

    public function getFreeEntry(): bool
    {
        return $this->freeEntry;
    }

    public function setFreeEntry(bool $freeEntry)
    {
        $this->freeEntry = $freeEntry;
    }

    /**
     * @return Link|null
     */
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    public function setTicketLink(Link $ticketLink = null)
    {
        $this->ticketLink = $ticketLink;
    }

    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    public function removeCategory(Category $category)
    {
        $this->categories->detach($category);
    }

    /**
     * @return ObjectStorage|Category[]
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * A helper method to get all category UIDs as array
     */
    public function getCategoryUids(): array
    {
        $categoryUids = [];
        foreach ($this->categories as $category) {
            $categoryUids[] = $category->getUid();
        }
        return $categoryUids;
    }

    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    public function addDay(Day $day)
    {
        $this->days->attach($day);
    }

    public function removeDay(Day $day)
    {
        $this->days->detach($day);
    }

    /**
     * @return ObjectStorage|Day[] $days
     */
    public function getDays(): ObjectStorage
    {
        return $this->days;
    }

    /**
     * Returns grouped and sorted days of today and future.
     *
     * @return array|\DateTime[]
     */
    public function getFutureDatesGroupedAndSorted(): array
    {
        $dateTimeUtility = GeneralUtility::makeInstance(DateTimeUtility::class);
        $today = $dateTimeUtility->standardizeDateTimeObject(new \DateTime());

        $futureDates = [];
        foreach ($this->getDays() as $day) {
            if ($day->getDayTime() > $today) {
                $futureDay = clone $day;
                $futureDates[$futureDay->getDay()->format('U')] = $futureDay->getDay();
            }
        }
        ksort($futureDates);
        reset($futureDates);

        return $futureDates;
    }

    /**
     * Returns grouped and sorted days of today and future.
     * This method also returns days which are marked as removed (is_removed=1).
     *
     * @return array|\DateTime[]
     */
    public function getFutureDatesIncludingRemovedGroupedAndSorted(): array
    {
        $dateTimeUtility = GeneralUtility::makeInstance(DateTimeUtility::class);
        $today = $dateTimeUtility->standardizeDateTimeObject(new \DateTime());

        $futureDates = $this->getFutureDatesGroupedAndSorted();
        foreach ($this->getExceptions('remove') as $exception) {
            if ($exception->getExceptionDate() > $today) {
                $exceptionDate = clone $exception->getExceptionDate();
                $futureDates[$exceptionDate->format('U')] = $exceptionDate;
            }
        }

        ksort($futureDates);
        reset($futureDates);

        return $futureDates;
    }

    public function setDays(ObjectStorage $days)
    {
        $this->days = $days;
    }

    /**
     * Returns the location.
     * Since version 2.3.1 this property can be (not must be) required
     *
     * @return Location|null $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(Location $location = null)
    {
        $this->location = $location;
    }

    /**
     * Returns the organizer.
     * Since version 2.3.1 this property can be (not must be) required
     *
     * @return Organizer|null
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function setOrganizer(Organizer $organizer = null)
    {
        $this->organizer = $organizer;
    }

    /**
     * @return array|FileReference[]
     */
    public function getImages(): array
    {
        // ObjectStorage has SplObjectHashes as key which we don't know in Fluid
        // so we convert ObjectStorage to array to get numbered keys
        $references = [];
        foreach ($this->images as $image) {
            $references[] = $image;
        }

        return $references;
    }

    public function setImages(ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * @return Link|null
     */
    public function getVideoLink()
    {
        return $this->videoLink;
    }

    public function setVideoLink(Link $videoLink = null)
    {
        $this->videoLink = $videoLink;
    }

    /**
     * @return ObjectStorage|Link[]
     */
    public function getDownloadLinks(): ObjectStorage
    {
        return $this->downloadLinks;
    }

    public function setDownloadLinks(ObjectStorage $downloadLinks)
    {
        $this->downloadLinks = $downloadLinks;
    }

    public function addDownloadLink(Link $downloadLink)
    {
        $this->downloadLinks->attach($downloadLink);
    }

    public function removeDownloadLink(Link $downloadLink)
    {
        $this->downloadLinks->detach($downloadLink);
    }

    public function getImportId(): string
    {
        return $this->importId;
    }

    public function setImportId(string $importId)
    {
        $this->importId = $importId;
    }
}
