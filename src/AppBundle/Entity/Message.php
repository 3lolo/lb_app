<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.12.15
 * Time: 14:38
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="messages")
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $fromId;

    /**
     * @ORM\Column(type="integer")
     */
    protected $toId;
    /**
     * @ORM\Column(type="string")
     */
    protected $message;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_time;
    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $fromId
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }

    /**
     * @param mixed $toId
     */
    public function setToId($toId)
    {
        $this->toId = $toId;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $date_time
     */
    public function setDateTime($date_time)
    {
        $this->date_time = $date_time;
    }

    /**
     * @param mixed $read
     */
    public function setStatus($read)
    {
        $this->status = $read;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @return mixed
     */
    public function getToId()
    {
        return $this->toId;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->date_time;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    function findByFromId($id){

        if($this->fromId == $id)
            return this;
    }
    function findByToId($id){

        if($this->fromId == $id)
            return this;
    }


}
?>