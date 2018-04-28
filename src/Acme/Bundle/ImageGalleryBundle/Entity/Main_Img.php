<?php

namespace Acme\Bundle\ImageGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Main_Img
 *
 * @ORM\Table(name="main_img")
 * @ORM\Entity(repositoryClass="Acme\Bundle\ImageGalleryBundle\Repository\Main_ImgRepository")
 */
class Main_Img
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
     *@ORM\Column(type="integer")
     */
    private $productId;
    /**
     *@ORM\Column(type="integer", name="img_id")
     */
    private $imgId;
    /**
     *@ORM\OneToOne(targetEntity="Images", inversedBy="mainImg")
     *@ORM\JoinColumn(name="img_id", referencedColumnName="id")
     */
    private $images;

    public function __construct()
    {

    }
    /**
     * Get id
     *
     * @return int
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
     * @return Main_Img
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
     * Set imgId
     *
     * @param integer $imgId
     *
     * @return Main_Img
     */
    public function setImgId($imgId)
    {
        $this->imgId = $imgId;

        return $this;
    }

    /**
     * Get imgId
     *
     * @return integer
     */
    public function getImgId()
    {
        return $this->imgId;
    }

    /**
     * Set images
     *
     * @param \Acme\Bundle\ImageGalleryBundle\Entity\Images $images
     *
     * @return Main_Img
     */
    public function setImages(\Acme\Bundle\ImageGalleryBundle\Entity\Images $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Acme\Bundle\ImageGalleryBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->images;
    }
}
