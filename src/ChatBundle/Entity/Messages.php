<?php

namespace ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="ChatBundle\Repository\MessagesRepository")
 */
class Messages
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
    private $from_id;
    /**
     *@ORM\Column(type="integer")
     */
    private $whom_id;
    /**
     *@ORM\Column(type="text")
     */
    private $message;
    /**
     *@ORM\Column(type="integer")
     */
    private $IsDeleteFrom;
    /**
     *@ORM\Column(type="integer")
     */
    private $is_delete_whom;
    /**
     *@ORM\Column(type="date")
     */
    private $created;
    public function __construct()
    {
        $this->created = new \DateTime();
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
     * Set fromId
     *
     * @param integer $fromId
     *
     * @return Messages
     */
    public function setFromId($fromId)
    {
        $this->from_id = $fromId;

        return $this;
    }

    /**
     * Get fromId
     *
     * @return integer
     */
    public function getFromId()
    {
        return $this->from_id;
    }

    /**
     * Set whomId
     *
     * @param integer $whomId
     *
     * @return Messages
     */
    public function setWhomId($whomId)
    {
        $this->whom_id = $whomId;

        return $this;
    }

    /**
     * Get whomId
     *
     * @return integer
     */
    public function getWhomId()
    {
        return $this->whom_id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Messages
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isDeleteFrom
     *
     * @param integer $isDeleteFrom
     *
     * @return Messages
     */
    public function setIsDeleteFrom($isDeleteFrom)
    {
        $this->IsDeleteFrom = $isDeleteFrom;

        return $this;
    }

    /**
     * Get isDeleteFrom
     *
     * @return integer
     */
    public function getIsDeleteFrom()
    {
        return $this->IsDeleteFrom;
    }

    /**
     * Set isDeleteWhom
     *
     * @param integer $isDeleteWhom
     *
     * @return Messages
     */
    public function setIsDeleteWhom($isDeleteWhom)
    {
        $this->is_delete_whom = $isDeleteWhom;

        return $this;
    }

    /**
     * Get isDeleteWhom
     *
     * @return integer
     */
    public function getIsDeleteWhom()
    {
        return $this->is_delete_whom;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Messages
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
