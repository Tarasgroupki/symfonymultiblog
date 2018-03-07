<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

class MultiCategory
{
	/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $cat_id;
/**
 * @ORM\Column(type="string")
*/
    private $locale;
/**
 *@ORM\Column(type="integer")
*/  
private $categoryId;
/**
*@ORM\Column(type="string")
*/
private $parentId;
private $cat_name;
/**
 *@ORM\Column(type="text")
*/
private $description_cat;

    public function setCat_id($id)
    {
       return $this->cat_id = $id;
    }
   /**
     * Get cat_id
     *
     * @return integer
     */
    public function getCat_id()
    {
        return $this->cat_id;
    }
			 /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }
/**
     * Set parentId
     *
     * @param string $parentId
     *
     * @return Category
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }
	/**
     * Get cat_name
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->cat_name;
    }
/**
     * Set cat_name
     *
     * @param string $cat_name
     *
     * @return Category
     */
    public function setCatName($cat_name)
    {
        $this->cat_name = $cat_name;
    }
/**
     * Set description_cat
     *
     * @param text $description_cat
     *
     * @return Category
     */
    public function setDescriptionCat($description_cat)
    {
        $this->description_cat = $description_cat;

        return $this;
    }
/**
     * Get descriptionCat
     *
     * @return string
     */
    public function getDescriptionCat()
    {
        return $this->description_cat;
    }
    /**
     * Get description_cat
     *
     * @return text
     */
    public function getCategoryName()
    {
        return $this->description_cat;
    }
		/**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Category
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
}