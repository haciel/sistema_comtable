<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Account", inversedBy="operations", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $account_id;

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
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\AccountantMove", inversedBy="operations", cascade={"persist"})
     * @ORM\JoinColumn(name="accountmove_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $accountmove_id;

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
     * Set account_id
     *
     * @param \BackendBundle\Entity\Operations $account_id
     * @return Operations
     */
    public function setAccount_id(\BackendBundle\Entity\Operations $account_id = null)
    {
        $this->account_id =$account_id;

        return $this;
    }

    /**
     * Get account_id
     *
     * @return \BackendBundle\Entity\Account
     */
    public function getAccount_id()
    {
        return $this->account_id;
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
     * Set accountmove_id
     *
     * @param \BackendBundle\Entity\AccountantMove $accountmove_id
     * @return Operations
     */
    public function setAccountmove_id(\BackendBundle\Entity\AccountantMove $accountmove_id = null)
    {
        $this->accountmove_id =$accountmove_id;

        return $this;
    }

    /**
     * Get accountmove_id
     *
     * @return \BackendBundle\Entity\SlipType
     */
    public function getAccountmove_id()
    {
        return $this->accountmove_id;
    }
}
