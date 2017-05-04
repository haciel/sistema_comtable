<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Province
 *
 * @ORM\Table(name="province")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ProvinceRepository")
 */
class Province
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
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Country", inversedBy="provinces", cascade={"persist"})
     *  @ORM\JoinColumn(name="country_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $country_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\City", mappedBy="province_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $cities;

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
     * @return Province
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
     * Set country_id
     *
     * @param \BackendBundle\Entity\Country $country_id
     * @return Province
     */
    public function setCountry_id(\BackendBundle\Entity\Country $country_id = null)
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * Get country_id
     *
     * @return \BackendBundle\Entity\Country
     */
    public function getCountry_id()
    {
        return $this->country_id;
    }

    /**
     * Remove cities
     *
     * @param \BackendBundle\Entity\City $cities
     */
    public function removeCities(\BackendBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }
}
