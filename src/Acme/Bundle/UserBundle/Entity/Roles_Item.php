<?php

namespace Acme\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * Class Roles_Item
 * @package Acme\Bundle\UserBundle\Entity
 * @ORM\Table(name="roles_item")
 * @ORM\Entity
 */
class Roles_Item
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
     * @ORM\Column(type="text",name="description")
     */
	private $description;
	/**
    * @ORM\Column(type="date")
    */
    private $created;
    
	private $public;
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
     * @return Roles_Item
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
     * Set public
     *
     * @param string $public
     *
     * @return Roles_Item
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Roles_Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Roles_Item
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
