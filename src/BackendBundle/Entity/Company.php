<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="institution_id", type="integer")
     */
    private $institutionId;

    /**
     * @var int
     *
     * @ORM\Column(name="educationallevel_id", type="integer")
     */
    private $educationallevelId;


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
     * Set userId
     *
     * @param integer $userId
     * @return Company
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set institutionId
     *
     * @param integer $institutionId
     * @return Company
     */
    public function setInstitutionId($institutionId)
    {
        $this->institutionId = $institutionId;

        return $this;
    }

    /**
     * Get institutionId
     *
     * @return integer 
     */
    public function getInstitutionId()
    {
        return $this->institutionId;
    }

    /**
     * Set educationallevelId
     *
     * @param integer $educationallevelId
     * @return Company
     */
    public function setEducationallevelId($educationallevelId)
    {
        $this->educationallevelId = $educationallevelId;

        return $this;
    }

    /**
     * Get educationallevelId
     *
     * @return integer 
     */
    public function getEducationallevelId()
    {
        return $this->educationallevelId;
    }
}
