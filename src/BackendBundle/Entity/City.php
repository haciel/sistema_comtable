<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Province", inversedBy="cities", cascade={"persist"})
     *  @ORM\JoinColumn(name="province_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $province_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Institution", mappedBy="city_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $institution;

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
     * @return City
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
     * Set province_id
     *
     * @param \BackendBundle\Entity\Province $province_id
     * @return City
     */
    public function setProvince_id(\BackendBundle\Entity\Province $province_id = null)
    {
        $this->province_id =$province_id;

        return $this;
    }

    /**
     * Get province_id
     *
     * @return \BackendBundle\Entity\Province
     */
    public function getProvince_id()
    {
        return $this->province_id;
    }

    /**
     * Remove institution
     *
     * @param \BackendBundle\Entity\Institution $institution
     */
    public function removeInstitution(\BackendBundle\Entity\Institution $institution)
    {
        $this->institution->removeElement($institution);
    }

    /**
     * Get institution
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstitution()
    {
        return $this->institution;
    }

}
