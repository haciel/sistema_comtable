<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="dateLimit", type="string", length=255)
     */
    private $dateLimit;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $user_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\User", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id ", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $company_id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Account", mappedBy="task_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $answer;

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
     * Set dateLimit
     *
     * @param string $dateLimit
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
     * @return string 
     */
    public function getDateLimit()
    {
        return $this->dateLimit;
    }

    /**
     * Set user_id
     *
     * @param \UserBundle\Entity\User $user_id
     * @return Task
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
     * Set company_id
     *
     * @param \BackendBundle\Entity\Company $company_id
     * @return Task
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
     * Remove answer
     *
     * @param \BackendBundle\Entity\AnswerTask $answer
     */
    public function removeAnswer(\BackendBundle\Entity\AnswerTask $answer)
    {
        $this->answer->removeElement($answer);
    }

    /**
     * Get answer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
