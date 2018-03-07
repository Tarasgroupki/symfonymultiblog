<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Blog
 * @package BlogBundle\Entity
 * @ORM\Table(name="blog")
 * @ORM\Entity
*/

class Blog
{
/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $id;
/**
 *@ORM\Column(type="integer")
*/  
private $productId;
/**
 *@ORM\Column(type="integer")
*/  
private $categoryId;
/**
 *@ORM\Column(type="string")
*/  
private $locale;

/**
 * @ORM\Column(type="string")
*/

private $title;

protected $titles;

protected $bodies;
/**
 *@ORM\Column(type="text")
*/
private $body;
/**
 *@ORM\Column(type="string")
*/
private $slug;
/**
 *@ORM\Column(type="date")
*/
private $created;

public function __construct()
{
	$this->created = new \DateTime();
	$this->titles = new \Doctrine\Common\Collections\ArrayCollection();
	//$this->bodies = new \Doctrine\Common\Collections\ArrayCollection();
}

public function setTitles($titles)
    {
        $this->titles = $titles;

        return $this;
    }
    public function getTitles()
	{
		return $this->titles;
	}

	public function getBodies()
	{
		return $this->bodies;
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
     * Set productId
     *
     * @param integer $productId
     *
     * @return Blog
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }
/**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }	
	/**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Blog
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }
/**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
	/**
     * Set locale
     *
     * @param string $locale
     *
     * @return Blog
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
	  /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blog
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
     * Set body
     *
     * @param string $body
     *
     * @return Blog
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

/**
     * Set slug
     *
     * @param string $slug
     *
     * @return Blog
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Set created
     *
     * @param date $created
     *
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return date
     */
    public function getCreated()
    {
        return $this->created;
    }
}
