<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operations
 *
 * @ORM\Table(name="operations")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\OperationsRepository")
 */
class Operations
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
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer")
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="deve", type="decimal", precision=10, scale=0)
     */
    private $deve;

    /**
     * @var string
     *
     * @ORM\Column(name="haber", type="decimal", precision=10, scale=0)
     */
    private $haber;

    /**
     * @var int
     *
     * @ORM\Column(name="accountmove_id", type="integer")
     */
    private $accountmoveId;


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
     * Set accountId
     *
     * @param integer $accountId
     * @return Operations
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set deve
     *
     * @param string $deve
     * @return Operations
     */
    public function setDeve($deve)
    {
        $this->deve = $deve;

        return $this;
    }

    /**
     * Get deve
     *
     * @return string 
     */
    public function getDeve()
    {
        return $this->deve;
    }

    /**
     * Set haber
     *
     * @param string $haber
     * @return Operations
     */
    public function setHaber($haber)
    {
        $this->haber = $haber;

        return $this;
    }

    /**
     * Get haber
     *
     * @return string 
     */
    public function getHaber()
    {
        return $this->haber;
    }

    /**
     * Set accountmoveId
     *
     * @param integer $accountmoveId
     * @return Operations
     */
    public function setAccountmoveId($accountmoveId)
    {
        $this->accountmoveId = $accountmoveId;

        return $this;
    }

    /**
     * Get accountmoveId
     *
     * @return integer 
     */
    public function getAccountmoveId()
    {
        return $this->accountmoveId;
    }
}
