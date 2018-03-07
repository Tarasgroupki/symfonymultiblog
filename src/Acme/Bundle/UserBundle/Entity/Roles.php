<?php

namespace Acme\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * Class Roles
 * @package Acme\Bundle\UserBundle\Entity
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Acme\Bundle\UserBundle\Repository\RolesRepository")
 */
class Roles
{
/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/ 
	private $id;
	 /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $item_name;
	 /**
     * @ORM\Column(type="integer",name="user_id")
     */
    private $userId;
    /**
    * @ORM\Column(type="date")
    */
    private $created;

/**
  @ORM\ManyToOne(targetEntity="User", inversedBy="userRoles")
  @ORM\JoinColumn(name="user_id", referencedColumnName="id")
 */
 //   private $user;
    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Roles
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set itemName
     *
     * @param string $itemName
     *
     * @return Roles
     */
    public function setItemName($itemName)
    {
        $this->item_name = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Roles
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Roles
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
