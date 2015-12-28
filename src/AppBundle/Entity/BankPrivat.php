<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.15
 * Time: 13:32
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_user")
 */
class BankPrivat
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
    protected $idUser;
    /**
     * @ORM\Column(type="string")
     */
    protected $merchandId;
    /**
     * @ORM\Column(type="string")
     */
    protected $password;
    /**
     * @ORM\Column(type="string")
     */
    protected $cardnum;
    /**
     * @ORM\Column(type="string")
     */
    protected $fio;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->idUser = $id_user;
    }

    /**
     * @param mixed $cardnum
     */
    public function setCardnum($cardnum)
    {
        $this->cardnum = $cardnum;
    }

    /**
     * @return mixed
     */
    public function getMerchandId()
    {
        return $this->merchandId;
    }

    /**
     * @param mixed $merchandId
     */
    public function setMerchandId($merchandId)
    {
        $this->merchandId = $merchandId;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCardnum()
    {
        return $this->cardnum;
    }

    /**
     * @return mixed
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @param mixed $fio
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    }


    function findByIdUser($id){

        if($this->idUser == $id)
            return this;
    }


}