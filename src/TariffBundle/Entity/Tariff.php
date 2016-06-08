<?php

namespace TariffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Тариф (тарифный план) с набором Возможностей.
 * 
 * @ORM\Entity
 * @ORM\Table(name="tariff")
 */
class Tariff {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     * @var str
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1024)
     * @Assert\NotBlank()
     * @var str
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":true})
     * @var bool
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="FeatureConcrete", mappedBy="tariff", cascade={"remove", "persist"})
     * @var ArrayCollection
     */
    private $features;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     * @var int
     */
    private $price;

    public function __construct() {
        $this->features = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tariff
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Tariff
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Tariff
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Add features
     *
     * @param \TariffBundle\Entity\FeatureConcrete $feature
     * @return Tariff
     */
    public function addFeature(\TariffBundle\Entity\FeatureConcrete $feature) {
        $this->features[] = $feature;
        $feature->setTariff($this);

        return $this;
    }

    /**
     * Remove features
     *
     * @param \TariffBundle\Entity\FeatureConcrete $features
     */
    public function removeFeature(\TariffBundle\Entity\FeatureConcrete $features) {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures() {
        return $this->features;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tariff
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    public function __toString() {
        return $this->name;
    }

}
