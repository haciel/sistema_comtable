<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @ORM\Column(name="number_estudent", type="integer")
     */
    private $number_estudent;

    /**
     * @var city
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\City", inversedBy="institution", cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $city_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Company", mappedBy="institution_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $companies;

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
     * Set number_estudent
     *
     * @param integer $number_estudent
     * @return Institution
     */
    public function setNumber_estudent($number_estudent)
    {
        $this->number_estudent = $number_estudent;

        return $this;
    }

    /**
     * Get number_estudent
     *
     * @return integer 
     */
    public function getNumber_estudent()
    {
        return $this->number_estudent;
    }

    /**
     * Set city_id
     *
     * @param \BackendBundle\Entity\City $city_id
     * @return Institution
     */
    public function setCity_id(\BackendBundle\Entity\City $city_id = null)
    {
        $this->city_id = $city_id;

        return $this;
    }

    /**
     * Get city_id
     *
     * @return \BackendBundle\Entity\City
     */
    public function getCity_id()
    {
        return $this->city_id;
    }

    /**
     * Remove companies
     *
     * @param \BackendBundle\Entity\Company $companies
     */
    public function removeCompanies(\BackendBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
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
