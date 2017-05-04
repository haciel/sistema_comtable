<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="companies", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $user_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Institution", inversedBy="companies", cascade={"persist"})
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $institution_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\EducationalLevel", inversedBy="companies", cascade={"persist"})
     * @ORM\JoinColumn(name="educationallevel_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $educationallevel_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Task", mappedBy="company_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $tasks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\AccountantMove", mappedBy="company_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $accountans_move;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Account", mappedBy="company_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $accounts;

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
     * @return Company
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
     * Set user_id
     *
     * @param \UserBundle\Entity\User $user_id
     * @return Company
     */
    public function setUser_id(\UserBundle\Entity\User $user_id = null)
    {
        $this->user_id =$user_id;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set institution_id
     *
     * @param \BackendBundle\Entity\Institution $institution_id
     * @return Company
     */
    public function setInstitution_id(\BackendBundle\Entity\Institution $institution_id = null)
    {
        $this->institution_id =$institution_id;

        return $this;
    }

    /**
     * Get institution_id
     *
     * @return \BackendBundle\Entity\Institution
     */
    public function getInstitution_id()
    {
        return $this->institution_id;
    }

    /**
     * Set educationallevel_id
     *
     * @param \BackendBundle\Entity\EducationalLevel $educationallevel_id
     * @return Company
     */
    public function setEducationallevel_id(\BackendBundle\Entity\EducationalLevel $educationallevel_id = null)
    {
        $this->educationallevel_id =$educationallevel_id;

        return $this;
    }

    /**
     * Get educationallevel_id
     *
     * @return \BackendBundle\Entity\EducationalLevel
     */
    public function getEducationallevel_id()
    {
        return $this->$educationallevel_id;
    }

    /**
     * Remove tasks
     *
     * @param \BackendBundle\Entity\Task $tasks
     */
    public function removeTask(\BackendBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTask()
    {
        return $this->tasks;
    }

    /**
     * Remove accountans_move
     *
     * @param \BackendBundle\Entity\AccountantMove $accountans_move
     */
    public function removeAccountans_move(\BackendBundle\Entity\AccountantMove $accountans_move)
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

    /**
     * Remove accounts
     *
     * @param \BackendBundle\Entity\Account $accounts
     */
    public function removeAccount(\BackendBundle\Entity\Account $accounts)
    {
        $this->accounts->removeElement($accounts);
    }

    /**
     * Get account
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccount()
    {
        return $this->accounts;
    }

}
