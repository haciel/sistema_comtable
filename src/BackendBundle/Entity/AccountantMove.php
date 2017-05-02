<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="number_move", type="string", length=255)
     */
    private $numberMove;

    /**
     * @var int
     *
     * @ORM\Column(name="company_id", type="integer")
     */
    private $companyId;

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
     * @ORM\Column(name="slipe_id", type="integer")
     */
    private $slipeId;

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
     * Set companyId
     *
     * @param integer $companyId
     * @return AccountantMove
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->companyId;
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
     * Set slipeId
     *
     * @param integer $slipeId
     * @return AccountantMove
     */
    public function setSlipeId($slipeId)
    {
        $this->slipeId = $slipeId;

        return $this;
    }

    /**
     * Get slipeId
     *
     * @return integer 
     */
    public function getSlipeId()
    {
        return $this->slipeId;
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
