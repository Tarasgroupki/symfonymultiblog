<?php

namespace Acme\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * Class Profile
 * @package Acme\Bundle\UserBundle\Entity
 * @ORM\Table(name="profile")
 * @ORM\Entity
 */
class Profile
{
    /**
	 * @ORM\Id
     * @ORM\Column(type="integer")
     */
	 private $userId;
	 /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $first_name;
	 /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $second_name;

    /**
    * @ORM\Column(type="date")
    */
    private $birthday;
	
   /**
     * @Assert\File(
     *     maxSize = "2024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
	 *     mimeTypesMessage = "Please upload a valid PDF"
     * ) 
     */
	private $file;
	
	
	private $file_upload;
	 //private $user;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Profile
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Profile
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Profile
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     *
     * @return Profile
     */
    public function setSecondName($secondName)
    {
        $this->second_name = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->second_name;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Profile
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
	
	public function setFile( UploadedFile $file )
	{
		return $this->file = $file;
	}
	
	public function getFile()
	{
		return $this->file;
	}
	
	public function getFileUpload()
	{
		return $this->FileUpload;
	}
	
	public function setFileUpload( )
	{
		return $this->fileUpload = $fileUpload;
	}
}
