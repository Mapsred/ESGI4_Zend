<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 06/12/2017
 * Time: 14:24
 */

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Application\Repository\UserRepository")
 */
class User
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
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var ArrayCollection|Meetup[] $organizedMeetups
     * @ORM\OneToMany(targetEntity="Application\Entity\Meetup", mappedBy="organizer", cascade={"persist"})
     */
    private $organizedMeetups;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->organizedMeetups = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Add organizedMeetup.
     *
     * @param Meetup $organizedMeetup
     *
     * @return User
     */
    public function addOrganizedMeetup(Meetup $organizedMeetup)
    {
        $this->organizedMeetups[] = $organizedMeetup;

        return $this;
    }

    /**
     * Remove organizedMeetup.
     *
     * @param Meetup $organizedMeetup
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOrganizedMeetup(Meetup $organizedMeetup)
    {
        return $this->organizedMeetups->removeElement($organizedMeetup);
    }

    /**
     * Get organizedMeetups.
     *
     * @return ArrayCollection|Meetup[]
     */
    public function getOrganizedMeetups()
    {
        return $this->organizedMeetups;
    }

    /**
     * @return bool
     */
    public function hasOrganizedMeetup(): bool
    {
        return !$this->getOrganizedMeetups()->isEmpty();
    }

}
