<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SlipType
 *
 * @ORM\Table(name="slip_type")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\SlipTypeRepository")
 */
class SlipType
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
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\AccountantMove", mappedBy="slipe_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $accountans_move;

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
     * @return SlipType
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
     * Remove accountans_move
     *
     * @param \BackendBundle\Entity\SlipType $accountans_move
     */
    public function removeAccountans_move(\BackendBundle\Entity\SlipType $accountans_move)
    {
        $this->accountans_move->removeElement($accountans_move);
    }

    /**
     * Get accountans_move
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccountans_move()
    {
        return $this->accountans_move;
    }
}
