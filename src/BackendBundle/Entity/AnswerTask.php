<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * AnswerTask
 *
 * @ORM\Table(name="answer_task")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\AnswerTaskRepository")
 */
class AnswerTask
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
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $user_id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Task", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $task_id;

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
     * Set file
     *
     * @param string $file
     * @return AnswerTask
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set user_id
     *
     * @param \UserBundle\Entity\User $user_id
     * @return AnswerTask
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
     * Set task_id
     *
     * @param \BackendBundle\Entity\Task $task_id
     * @return AnswerTask
     */
    public function setTask_id(\BackendBundle\Entity\Task $task_id = null)
    {
        $this->task_id =$task_id;

        return $this;
    }

    /**
     * Get task_id
     *
     * @return \BackendBundle\Entity\Task
     */
    public function getTask_id()
    {
        return $this->task_id;
    }
}
