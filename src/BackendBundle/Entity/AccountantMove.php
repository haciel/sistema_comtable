<?php

namespace BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * AccountantMove
 *
 * @ORM\Table(name="accountant_move")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\AccountantMoveRepository")
 */
class AccountantMove
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
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Company", inversedBy="accountans_move", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $companyId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="slipe_number", type="integer")
     */
    private $slipeNumber;

    /**
     * @var SlipType
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\SlipType", inversedBy="accountans_move", cascade={"persist"})
     * @ORM\JoinColumn(name="slipe_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $slipeId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Operations", mappedBy="accountmoveId" ,cascade={"persist"},orphanRemoval=true)
     */
    private $operations;

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
     * Set description
     *
     * @param string $description
     * @return AccountantMove
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



    /**
     * Set slipeNumber
     *
     * @param integer $slipeNumber
     * @return AccountantMove
     */
    public function setSlipeNumber($slipeNumber)
    {
        $this->slipeNumber = $slipeNumber;

        return $this;
    }

    /**
     * Get slipeNumber
     *
     * @return integer 
     */
    public function getSlipeNumber()
    {
        return $this->slipeNumber;
    }

    /**
     * Set companyId
     *
     * @param \BackendBundle\Entity\Company $companyId
     * @return AccountantMove
     */
    public function setCompanyId(\BackendBundle\Entity\Company $companyId = null)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return \BackendBundle\Entity\Company 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set slipeId
     *
     * @param \BackendBundle\Entity\SlipType $slipeId
     * @return AccountantMove
     */
    public function setSlipeId(\BackendBundle\Entity\SlipType $slipeId = null)
    {
        $this->slipeId = $slipeId;

        return $this;
    }

    /**
     * Get slipeId
     *
     * @return \BackendBundle\Entity\SlipType 
     */
    public function getSlipeId()
    {
        return $this->slipeId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add operations
     *
     * @param \BackendBundle\Entity\Operations $operations
     * @return AccountantMove
     */
    public function addOperation(\BackendBundle\Entity\Operations $operations)
    {
        $this->operations[] = $operations;

        return $this;
    }

    /**
     * Remove operations
     *
     * @param \BackendBundle\Entity\Operations $operations
     */
    public function removeOperation(\BackendBundle\Entity\Operations $operations)
    {
        $this->operations->removeElement($operations);
    }

    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return AccountantMove
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return AccountantMove
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }
}
