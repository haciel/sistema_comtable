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
}
