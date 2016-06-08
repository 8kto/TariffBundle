<?php

namespace TariffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Конкретный экземпляр для сущности Свойства хостинга.
 * Например: 
 *     Домен в подарок = true, Место на диске = 2GB, Кол-во почтовых ящиков = 20
 * 
 * @ORM\Entity
 * @ORM\Table(name="feature_concrete")
 */
class FeatureConcrete {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Feature")
     * @var Feature
     */
    private $feature;

    /**
     * NOTE У значений — смешанный тип данных
     * 
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @var str
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="Tariff")
     * @var Tariff
     */
    private $tariff;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return FeatureConcrete
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Set feature
     *
     * @param \TariffBundle\Entity\Feature $feature
     * @return FeatureConcrete
     */
    public function setFeature(\TariffBundle\Entity\Feature $feature = null) {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature
     *
     * @return \TariffBundle\Entity\Feature 
     */
    public function getFeature() {
        return $this->feature;
    }


    /**
     * Set tariff
     *
     * @param \TariffBundle\Entity\Tariff $tariff
     * @return FeatureConcrete
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
}
