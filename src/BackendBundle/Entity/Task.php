<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="desciption", type="text")
     */
    private $desciption;

    /**
     * @var date
     *
     * @ORM\Column(name="dateLimit", type="date")
     */
    private $dateLimit;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $userId;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Company", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id ", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $companyId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Account", mappedBy="task_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $answers;

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
     * Set title
     *
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set desciption
     *
     * @param string $desciption
     * @return Task
     */
    public function setDesciption($desciption)
    {
        $this->desciption = $desciption;

        return $this;
    }

    /**
     * Get desciption
     *
     * @return string 
     */
    public function getDesciption()
    {
        return $this->desciption;
    }


    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set userId
     *
     * @param \UserBundle\Entity\User $userId
     * @return Task
     */
    public function setUserId(\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set companyId
     *
     * @param \BackendBundle\Entity\Company $companyId
     * @return Task
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
     * Add answers
     *
     * @param \BackendBundle\Entity\Account $answers
     * @return Task
     */
    public function addAnswer(\BackendBundle\Entity\Account $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \BackendBundle\Entity\Account $answers
     */
    public function removeAnswer(\BackendBundle\Entity\Account $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Set dateLimit
     *
     * @param \DateTime $dateLimit
     * @return Task
     */
    public function setDateLimit($dateLimit)
    {
        $this->dateLimit = $dateLimit;

        return $this;
    }

    /**
     * Get dateLimit
     *
     * @return \DateTime 
     */
    public function getDateLimit()
    {
        return $this->dateLimit;
    }
}
