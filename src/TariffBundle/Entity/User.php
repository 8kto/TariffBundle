<?php

namespace TariffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ ORM\OneToMany(targetEntity="Category", mappedBy="user", cascade={"remove"})
     */
//    private $categories;
     
    /**
     * @ORM\Column(type="string", nullable=true, options={"default":"UTC"})
     * @var string
     */
    private $timezone;

    public function __construct() {
        parent::__construct();

//        $this->categories = new ArrayCollection();
//        $this->history    = new ArrayCollection();
//        $this->cron       = new ArrayCollection();
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     *
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}
