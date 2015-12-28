<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $payday
     */
    public function setPayday($payday)
    {
        $this->payday = $payday;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @param mixed $credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }

    /**
     * @param mixed $picpath
     */
    public function setPicpath($picpath)
    {
        $this->picpath = $picpath;
    }

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $nick_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $password;

     /**
     * @ORM\Column(type="date")
     */
    protected $birthday;
    /**
     * @ORM\Column(type="text")
     */
    protected $phone;
    /**
     * @ORM\Column(type="text")
     */
    protected $status;
    /**
     * @ORM\Column(type="date")
     */
    protected $payday;
    /**
     * @ORM\Column(type="integer")
     */
    protected $total;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Column(type="integer")
     */
    protected $credit;
    /**
     * @ORM\Column(type="text")
     */
    protected $picpath;

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getPayday()
    {
        return $this->payday;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @return mixed
     */
    public function getPicpath()
    {
        return $this->picpath;
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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * Set mickName
     *
     * @param string $mickName
     *
     * @return User
     */
    public function setNickName($nickName)
    {
        $this->nick_name = $nickName;

        return $this;
    }

    /**
     * Get mickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
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

    public function findById($id){
        if($id==$this->id){
            return $this;
        }
    }

    public function findBy($data){
        if($this->email== $data['email']) {
            if ($this->password = $data['password']) {
                return $this->getInfo();
            }
        }
    }

    public function findByEmail($mail){
        if($this->email = $mail)
            return $this;
    }

    public function findByPhone($phone){
        if($this->phone ==$phone)
            return $this->$phone;
    }

    public function findByCredit($credit){
        if($this->credit ==$credit)
            return true;
    }


    public function findByName($name){
        if($this->name ==$name)
            return $this->name;
    }



}
?>