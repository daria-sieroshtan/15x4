<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="announcement")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AnnouncementRepository")
 */
class Announcement
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var City
     * @ORM\ManyToOne(
     *  targetEntity="City",
     *  inversedBy="announcements"
     * )
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $city;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\LectureAnnouncement[]
     * @ORM\OneToMany(
     *  targetEntity="\AppBundle\Entity\LectureAnnouncement",
     *  mappedBy="event",
     *  cascade={"persist"},
     *  orphanRemoval=true
     * )
     * @Assert\Valid()
     */
    protected $lectures;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    protected $date;

    /**
     * @ORM\Column(name="place", type="text", nullable=true)
     */
    protected $where;

    /**
     * @ORM\Column(name="place_map", type="text", nullable=true)
     */
    protected $whereMap;

    /**
     * @ORM\Column(name="vk_link", type="text", nullable=true)
     */
    protected $vkLink;

    /**
     * @ORM\Column(name="fb_link", type="text", nullable=true)
     */
    protected $fbLink;

    /**
     * @ORM\Column(name="time", type="text", nullable=true)
     */
    protected $when;

    /**
     * @var integer
     * @ORM\Column(name="total_tickets", type="integer", nullable=false)
     */
    protected $totalTickets = 0;

    /**
     * @var array
     * @ORM\Column(name="tickets_booked", type="json_array", nullable=true)
     */
    protected $ticketsBooked = [];

    /**
     * @var array
     * @ORM\Column(name="volunteers", type="json_array", nullable=true)
     */
    protected $volunteers = [];

    public function __construct()
    {
        $this->lectures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return sprintf(
            '%s, %s',
            $this->getCity(),
            $this->getDate()->format('d.m.Y')
        );
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return \DateTime */
    public function getDate()
    {
        return $this->date;
    }

    /** @param \DateTime $date */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @param City $city
     * @return self
     */
    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /** @return City */
    public function getCity()
    {
        return $this->city;
    }

    /** @return string */
    public function getWhen()
    {
        return $this->when;
    }

    /** @param string $when */
    public function setWhen($when)
    {
        $this->when = $when;
    }

    /** @return string */
    public function getWhere()
    {
        return $this->where;
    }

    /** @param string $where */
    public function setWhere($where)
    {
        $this->where = $where;
    }

    /** @return string */
    public function getWhereMap()
    {
        return $this->whereMap ?: $this->getWhere();
    }

    /** @param string $whereMap */
    public function setWhereMap($whereMap)
    {
        $this->whereMap = $whereMap;
    }

    /** @param LectureAnnouncement $lecture */
    public function addLecture(LectureAnnouncement $lecture)
    {
        if (false === $this->lectures->contains($lecture)) {
            $this->lectures->add($lecture);
        }
        $lecture->setEvent($this);
    }

    /** @param LectureAnnouncement $lecture */
    public function removeLecture(LectureAnnouncement $lecture)
    {
        $this->lectures->removeElement($lecture);
    }

    /** @return LectureAnnouncement[]|\Doctrine\Common\Collections\ArrayCollection */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param string $name
     * @param int $ticketsToBook
     */
    public function addTicketsBooking($name, $ticketsToBook = 1)
    {
        while ($ticketsToBook > 0) {
            $this->ticketsBooked[] = $name;
            $ticketsToBook--;
        }
    }

    /**
     * @param string $name
     * @param string $contact
     */
    public function addVolunteer($name, $contact)
    {
        $this->volunteers[] = [$name, $contact];
    }

    /** @return array */
    public function getVolunteers()
    {
        return $this->volunteers;
    }

    /** @return array */
    public function getTicketsBookedGrouped()
    {
        $grouped = array_count_values($this->ticketsBooked);
        ksort($grouped);
        $mapped = [];
        foreach($grouped as $name => $ticketsNumber) {
            $mapped[] = [
                $name,
                $ticketsNumber
            ];
        }

        return $mapped;
    }

    /** @return bool */
    public function isRegisterable()
    {
        return (bool)$this->getTotalTickets();
    }

    /** @return bool */
    public function hasFreeTickets()
    {
        return $this->totalTickets > count($this->ticketsBooked);
    }

    /** @param int $totalTickets */
    public function setTotalTickets($totalTickets)
    {
        $this->totalTickets = $totalTickets;
    }

    /** @return int */
    public function getTotalTickets()
    {
        return $this->totalTickets;
    }

    /**
     * @return string
     */
    public function getVkLink()
    {
        return $this->vkLink;
    }

    /**
     * @param string $vkLink
     */
    public function setVkLink($vkLink)
    {
        $this->vkLink = $vkLink;
    }

    /**
     * @return string
     */
    public function getFbLink()
    {
        return $this->fbLink;
    }

    /**
     * @param string $fbLink
     */
    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
    }

    /** @return \DateTime */
    public function getDateTime()
    {
        $date = clone $this->getDate();

        //like "19:00"
        if (preg_match("/^[0-2][0-9]:[0-5][0-9]$/", $this->getWhen())) {
            return $date->setTime(substr($this->getWhen(), 0, 2), substr($this->getWhen(), 3, 2));
        }

        //like "19:00 - 22:00"
        if (preg_match("/^[0-2][0-9]:[0-5][0-9] - [0-2][0-9]:[0-5][0-9]$/", $this->getWhen())) {
            return $date->setTime(substr($this->getWhen(), 0, 2), substr($this->getWhen(), 3, 2));
        }
        
        //random guess
        return $date->setTime(19, 0);
    }

    /** @return \DateTime */
    public function getEndDateTime()
    {
        $date = clone $this->getDateTime();
        $date->modify('+2 hours');

        return $date;
    }
}
