<?php

namespace TariffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Абстрактная сущность для описания какого-либо Свойства хостинга.
 * Например: Домен в подарок, Место на диске, Кол-во почтовых ящиков.
 *
 * @ORM\Entity
 * @ORM\Table(name="feature")
 */
class Feature {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     * @var str
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\NotBlank()
     * @var str
     */
    private $description;


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
     * Set name
     *
     * @param string $name
     * @return Feature
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Feature
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
