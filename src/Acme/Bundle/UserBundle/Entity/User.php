<?php
namespace Acme\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\Bundle\UserBundle\Entity\Roles;
use Acme\BlogBundle\Entity\Comment;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package Acme\Bundle\UserBundle\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Acme\Bundle\UserBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer",name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

	private $plainPassword;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
	
	private $roles = [];
	//private $profile;
   /**
      @var \Doctrine\Common\Collections\Collection
     */
//	protected $comments;
	
	 /**
	  @var \Doctrine\Common\Collections\Collection
      @ORM\OneToMany(targetEntity="Roles", mappedBy="user") 
    */
    //private $userRoles;

    public function __construct()
    {
        $this->isActive = true;
		//$this->comments = new ArrayCollection();
		//$this->userRoles = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

	public function getId()
	{
		return $this->id;
	}
	
    public function getUsername()
    {
        return $this->username;
    }
	public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
	 public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

	public function setPassword($password)
    {
        $this->password = $password;
    }
/**
     * Add Roles
     *
     * @param \Acme\Bundle\UserBundle\Entity\User $userRoles
     *
     * @return User
     */
  public function setUserRoles(\Acme\Bundle\UserBundle\Entity\User $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }	
    /**
      Get userRoles
     *
      @return \Doctrine\Common\Collections\Collection
     */
    /*public function getUserRoles()
    {
        return $this->userRoles;
    }*/
	public function setRoles($roles)
	{
		return $this->roles = $roles;
	}
    public function getRoles()
    {
        return $this->roles;
    }
	 /*public function getRoles()
    {
        return $this->getUserRoles()->map(function ($item) {
            return $item->getName();
        })->toArray();
    }*/

    public function eraseCredentials()
    {
		$this->password = null;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add comment
     *
     * @param \Acme\BlogBundle\Entity\Comment $comment
     *
     * @return User
     */
  /*  public function addComment(\Acme\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Acme\BlogBundle\Entity\Comment $comment
     */
  /*  public function removeComment(\Acme\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    /*public function getComments()
    {
        return $this->comments;
    }*/
}
