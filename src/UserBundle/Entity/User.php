<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Company", mappedBy="user_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $companies;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\Task", mappedBy="user_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $tasks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BackendBundle\Entity\AnswerTask", mappedBy="user_id" ,cascade={"persist"},orphanRemoval=true)
     */
    private $answer_tasks;

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
     * Remove companies
     *
     * @param \BackendBundle\Entity\Company $companies
     */
    public function removeCompanies(\BackendBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Remove tasks
     *
     * @param \BackendBundle\Entity\Task $tasks
     */
    public function removeTasks(\BackendBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Remove answer_tasks
     *
     * @param \BackendBundle\Entity\AnswerTask $answer_tasks
     */
    public function removeAnswer_tasks(\BackendBundle\Entity\AnswerTask $answer_tasks)
    {
        $this->answer_tasks->removeElement($answer_tasks);
    }

    /**
     * Get answer_tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswer_tasks()
    {
        return $this->answer_tasks;
    }
}
