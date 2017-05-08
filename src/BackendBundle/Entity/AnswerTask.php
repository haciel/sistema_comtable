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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $userId;

    /**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Task", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $taskId;

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
     * Set userId
     *
     * @param \UserBundle\Entity\User $userId
     * @return AnswerTask
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
     * Set taskId
     *
     * @param \BackendBundle\Entity\Task $taskId
     * @return AnswerTask
     */
    public function setTaskId(\BackendBundle\Entity\Task $taskId = null)
    {
        $this->taskId = $taskId;

        return $this;
    }

    /**
     * Get taskId
     *
     * @return \BackendBundle\Entity\Task 
     */
    public function getTaskId()
    {
        return $this->taskId;
    }
}
