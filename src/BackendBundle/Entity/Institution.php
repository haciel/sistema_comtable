<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Institution
 *
 * @ORM\Table(name="institution")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\InstitutionRepository")
 */
class Institution
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="levels", type="integer")
     */
    private $levels;

    /**
     * @var int
     *
     * @ORM\Column(name="number_estudent", type="integer")
     */
    private $numberEstudent;

    /**
     * @var string
     *
     * @ORM\Column(name="city_id", type="string", length=255)
     */
    private $cityId;

    /**
     * @var bool
     *
     * @ORM\Column(name="enable", type="boolean")
     */
    private $enable;


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
     * @return Institution
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
     * Set levels
     *
     * @param integer $levels
     * @return Institution
     */
    public function setLevels($levels)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Get levels
     *
     * @return integer 
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set numberEstudent
     *
     * @param integer $numberEstudent
     * @return Institution
     */
    public function setNumberEstudent($numberEstudent)
    {
        $this->numberEstudent = $numberEstudent;

        return $this;
    }

    /**
     * Get numberEstudent
     *
     * @return integer 
     */
    public function getNumberEstudent()
    {
        return $this->numberEstudent;
    }

    /**
     * Set cityId
     *
     * @param string $cityId
     * @return Institution
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return string 
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     * @return Institution
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return boolean 
     */
    public function getEnable()
    {
        return $this->enable;
    }
}
