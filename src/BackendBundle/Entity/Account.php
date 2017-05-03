<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\AccountRepository")
 */
class Account
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
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\AccountType", inversedBy="accounts", cascade={"persist"})
     * @ORM\JoinColumn(name="accounttype_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $accounttype_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Company", inversedBy="accounts", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $company_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Operations", mappedBy="account_id" ,cascade={"persist"},orphanRemoval=true)
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
     * Set code
     *
     * @param integer $code
     * @return Account
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Account
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
     * Set accounttype_id
     *
     * @param \BackendBundle\Entity\AccountType $accounttype_id
     * @return Account
     */
    public function setAccounttype_id(\BackendBundle\Entity\AccountType $accounttype_id= null)
    {
        $this->accounttype_id =$accounttype_id;

        return $this;
    }

    /**
     * Get accounttype_id
     *
     * @return \BackendBundle\Entity\AccountType
     */
    public function getAccounttype_id()
    {
        return $this->accounttype_id;
    }

    /**
     * Set company_id
     *
     * @param \BackendBundle\Entity\Company $company_id
     * @return Account
     */
    public function setCompany_id(\BackendBundle\Entity\Company $company_id= null)
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
     * Remove operations
     *
     * @param \BackendBundle\Entity\Operations $operations
     */
    public function removeOperations(\BackendBundle\Entity\Operations $operations)
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
}
