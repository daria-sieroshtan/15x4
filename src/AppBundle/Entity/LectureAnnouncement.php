<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LectureAnnouncementRepository")
 * @ORM\Table(name="lecture_announcement")
 */
class LectureAnnouncement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=127, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(name="teaser", type="text", nullable=true)
     */
    protected $teaser;

    /**
     * @var Lecturer
     * @ORM\ManyToOne(
     *  targetEntity="Lecturer",
     *  inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @Assert\NotBlank()
     */
    protected $lecturer;

    /**
     * @var Announcement
     * @ORM\ManyToOne(
     *  targetEntity="Announcement",
     *  inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $event;

    /**
     * @var Field
     * @ORM\ManyToOne(
     *   targetEntity="Field",
     *   inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $field;

    /**
     * @ORM\Column(name="language", type="string", length=3, nullable=false, options={"default": "ru"})
     */
    protected $language;

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getTitle();
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getTitle()
    {
        return $this->title;
    }

    /** @param string $title */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** @return string */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /** @param string $teaser */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    /** @return Lecturer */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /** @param Lecturer $lecturer */
    public function setLecturer(Lecturer $lecturer)
    {
        $this->lecturer = $lecturer;
    }

    /** @return Field */
    public function getField()
    {
        return $this->field;
    }

    /** @param Field $field */
    public function setField(Field $field)
    {
        $this->field = $field;
    }

    /** @param Announcement $event */
    public function setEvent(Announcement $event)
    {
        $this->event = $event;
    }

    /** @return Announcement */
    public function getEvent()
    {
        return $this->event;
    }

    /** @return string */
    public function getLanguage()
    {
        return $this->language;
    }

    /** @param string $language */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}
