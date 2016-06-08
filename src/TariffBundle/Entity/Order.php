<?php

namespace TariffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Заказ на тарифный план клиента.
 * 
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tariff")
     * @var Tariff
     */
    private $tariff;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     * @var bool
     */
    private $paid;

    /**
     * @ORM\Column(type="date", name="start_date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", name="end_date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $endDate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     * @return Order
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean 
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Order
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Order
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set tariff
     *
     * @param \TariffBundle\Entity\Tariff $tariff
     * @return Order
     */
    public function setTariff(\TariffBundle\Entity\Tariff $tariff = null)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * Get tariff
     *
     * @return \TariffBundle\Entity\Tariff 
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * Set user
     *
     * @param \TariffBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\TariffBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TariffBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
