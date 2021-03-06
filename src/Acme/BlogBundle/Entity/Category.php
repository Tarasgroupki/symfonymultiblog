<?php
namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Category
 * @package BlogBundle\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity
*/

class Category
{
	/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $cat_id;
/**
*@ORM\Column(type="string")
*/
private $cat_name;
/**
*@ORM\Column(type="string")
*/
private $locale;
/**
*@ORM\Column(type="text")
*/
private $description_cat;
/**
 *@ORM\Column(type="date")
*/
private $created;
/**
*@ORM\Column(type="string")
*/
private $categoryId;
/**
*@ORM\Column(type="string")
*/
private $parentId;
/**
*@ORM\Column(type="string")
*/
private $slug;
/**
@ORM\Column(type="array")
*/
public $child;
protected $categories;
protected $multi_categories;

public function __construct()
{
	$this->created = new \DateTime();
	$this->multi_categories = new \Doctrine\Common\Collections\ArrayCollection();
}

    public function setMultiCategories($multi_categories)
    {
        $this->multi_categories = $multi_categories;

        return $this;
    }
    public function getMultiCategories()
	{
		return $this->multi_categories;
	}
 public function setCategories($multi_categories)
    {
        $this->categories = $multi_categories;

        return $this;
    }
    public function getCategories()
	{
		return $this->categories;
	}   
   /**
     * Get catId
     *
     * @return integer
     */
    public function getCat_id()
    {
        return $this->cat_id;
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
     * Set categoryId
     *
     * @param string $categoryId
     *
     * @return Category
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
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
     * Set catName
     *
     * @param string $catName
     *
     * @return Category
     */
    public function setCatName($catName)
    {
        $this->cat_name = $catName;

        return $this;
    }

    /**
     * Get catName
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->cat_name;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return Category
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
     * Set descriptionCat
     *
     * @param string $descriptionCat
     *
     * @return Category
     */
    public function setDescriptionCat($descriptionCat)
    {
        $this->description_cat = $descriptionCat;

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
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
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
     * @param \DateTime $created
     *
     * @return Category
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
     * Get catId
     *
     * @return integer
     */
    public function getCatId()
    {
        return $this->cat_id;
    }
}
