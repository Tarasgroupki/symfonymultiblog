<?php
namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\Bundle\UserBundle\Entity\User;
//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Comment
 * @package BlogBundle\Entity
 * @ORM\Table(name="comment")
 * @ORM\Entity
*/

class Comment
{
	/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $id;
/**
*@ORM\Column(type="string")
*/
private $title;
/**
*@ORM\Column(type="string")
*/
private $username;
/**
*@ORM\Column(type="integer")
*/
private $postId;
/**
*@ORM\Column(type="text")
*/
private $text;
/**
 *@ORM\Column(type="date")
*/
private $created;
/**
  @ORM\ManyToOne(targetEntity="Acme\Bundle\UserBundle\Entity\User", inversedBy="comments")
  @ORM\JoinColumn(name="user_id",referencedColumnName="id")
 */
//protected $user;
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
     *
     * @return Comment
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
     * Set postId
     *
     * @param integer $postId
     *
     * @return Comment
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Get postId
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Comment
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

    /**
     * Set user
     *
     * @param \Acme\Bundle\UserBundle\Entity\User $user
     *
     * @return Comment
     */
  /*  public function setUser(\Acme\Bundle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\Bundle\UserBundle\Entity\User
     */
  /*  public function getUser()
    {
        return $this->user;
    }*/

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Comment
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
