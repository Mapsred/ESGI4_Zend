<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 06/12/2017
 * Time: 14:24
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class User
 *
 * @ORM\Table(name="meetup")
 * @ORM\Entity(repositoryClass="Application\Repository\MeetupRepository")
 */
class Meetup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime $startDate
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime $endDate
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Meetup
     */
    public function setId(int $id): Meetup
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Meetup
     */
    public function setTitle(string $title): Meetup
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Meetup
     */
    public function setDescription(string $description): Meetup
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return Meetup
     */
    public function setStartDate($startDate): Meetup
    {
        $this->startDate = $this->stringToDate($startDate);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return Meetup
     */
    public function setEndDate($endDate): Meetup
    {
        $this->endDate = $this->stringToDate($endDate);

        return $this;
    }

    /**
     * @param $date
     * @return bool|\DateTime
     */
    public function stringToDate($date): \DateTime
    {
        if (! $date instanceof \DateTime) {
            $date = \DateTime::createFromFormat('d/m/Y', $date);
        }

        return $date;
    }
}
