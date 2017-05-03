<?php

namespace BackendBundle\Entity;

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
     * * @var int
     *
     * @ORM\Column(name="numberMove", type="integer")
     * @ORM\NumberMove
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $numberMove;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Company", inversedBy="accountans_move", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $company_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="slipe_number", type="string", length=255)
     */
    private $slipeNumber;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\SlipType", inversedBy="accountans_move", cascade={"persist"})
     * @ORM\JoinColumn(name="slipe_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $slipe_id ;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
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
     * Set numberMove
     *
     * @param string $numberMove
     * @return AccountantMove
     */
    public function setNumberMove($numberMove)
    {
        $this->numberMove = $numberMove;

        return $this;
    }

    /**
     * Get numberMove
     *
     * @return string 
     */
    public function getNumberMove()
    {
        return $this->numberMove;
    }


    /**
     * Set company_id
     *
     * @param \BackendBundle\Entity\Company $company_id
     * @return AccountantMove
     */
    public function setCompany_id(\BackendBundle\Entity\Company $company_id = null)
    {
        $this->company_id =$company_id;

        return $this;
    }

    /**
     * Get company_id
     *
     * @return \BackendBundle\Entity\Company
     */
    public function getCompany_id()
    {
        return $this->company_id;
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
     * Set slipeNumber
     *
     * @param string $slipeNumber
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
     * @return string 
     */
    public function getSlipeNumber()
    {
        return $this->slipeNumber;
    }

    /**
     * Set slipe_id
     *
     * @param \BackendBundle\Entity\SlipType $slipe_id
     * @return AccountantMove
     */
    public function setSlipe_id(\BackendBundle\Entity\SlipType $slipe_id = null)
    {
        $this->slipe_id =$slipe_id;

        return $this;
    }

    /**
     * Get slipe_id
     *
     * @return \BackendBundle\Entity\SlipType
     */
    public function getSlipe_id()
    {
        return $this->slipe_id;
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
}
