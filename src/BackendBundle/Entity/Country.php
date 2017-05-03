<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\CountryRepository")
 */
class Country
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Province", mappedBy="country_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $provinces;

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
     * @return Country
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
     * Remove provinces
     *
     * @param \BackendBundle\Entity\Province $provinces
     */
    public function removeProvinces(\BackendBundle\Entity\Province $provinces)
    {
        $this->provinces->removeElement($provinces);
    }

    /**
     * Get provinces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvinces()
    {
        return $this->provinces;
    }
}
