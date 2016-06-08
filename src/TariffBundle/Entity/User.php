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
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user", cascade={"remove"})
     */
    private $orders;

    /**
     * @ORM\Column(type="string", nullable=true, options={"default":"UTC"})
     * @var string
     */
    private $timezone;

    public function __construct() {
        parent::__construct();

        $this->orders = new ArrayCollection();
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     *
     * @return User
     */
    public function setTimezone($timezone) {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone() {
        return $this->timezone;
    }


    /**
     * Add orders
     *
     * @param \TariffBundle\Entity\Order $orders
     * @return User
     */
    public function addOrder(\TariffBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \TariffBundle\Entity\Order $orders
     */
    public function removeOrder(\TariffBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
