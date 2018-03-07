<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

class Title
{
	/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $id;
/**
 * @ORM\Column(type="string")
*/
    private $locale;
/**
 *@ORM\Column(type="integer")
*/  
private $productId;

    private $title;
/**
 *@ORM\Column(type="text")
*/
private $body;

    public function setId($id)
    {
       return $this->id = $id;
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
    }
/**
     * Set body
     *
     * @param text $body
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
     * @return text
     */
    public function getBody()
    {
        return $this->body;
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
}