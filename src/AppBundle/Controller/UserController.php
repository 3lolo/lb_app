<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.12.15
 * Time: 12:56
 */

namespace AppBundle\Controller;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends Controller
{
    /**
     * @Route("/checkUser/{email}/{pswd}")
     */
    public function checkAction($email,$pswd)
    {
        $urepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $data = array('email'   =>  $email,
                      'password'    =>  $pswd
                     );
        $user = $urepo->findBy($data);
        $my_user  = $user[0];
        $ar = $this->createUser($my_user);

        $mess_array = array();
        $messages  = $this->forward('AppBundle:Messages:get', array("id"=>$my_user->getId()));
        //print_r($messages->getContent());
        $messages = json_decode($messages->getContent());
       // echo "messages";

        for($i =0;$i<count($messages);$i++){
            $mess = $messages[$i];

            $date = split(" ",$mess->date_time);//new Date( $mess->date_time);
            //print_r($date);
            array_push($mess_array,array("id"       =>  '1',
                                         "message"  =>  $mess->message,
                                         "name"     =>  $mess->to_id,
                                         "date"     =>  $date[0],
                                         "from"     =>  $mess->from_id));
        }

        $response = new JsonResponse();
        $response->setData(array('response'=>array('profile'=>array($ar),'messages'=>$mess_array)));
        return $response;
    }

    /**
     * @Route("/getUser/{email}/{pswd}")
     */
    public function getAction($email,$pswd)
    {

    }

    /**
     * @Route("/addUser/{uname}/{pswd}/{email}/{age}/{pic}/{phone}/{status}/{credit}")
     */
    public function addUserAction($uname,$pswd,$email,$age,$pic,$phone,$status,$credit)
    {
        $response = new JsonResponse();
        $res  = $this->uniqAction($uname,$email,$phone,$credit);
        if(empty($res)) {
            $date = new \DateTime($age);
            //$date->format('Y-m-d');
            $user = new User();
            $user->setName($uname);
            $user->setNickName($uname);

            $user->setPassword($pswd);
            $user->setEmail($email);
            $user->setBirthday($date);
            $user->setPicpath($pic);
            $user->setPhone($phone);
            $user->setStatus($status);
            $user->setCredit($credit);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //print_r($user);
            $response->setData(array('response'=>array('profile'=>array(array("valid"=>true)))));
        }
        else {
            $response->setData(array('response'=>array('profile'=>array($res))));
        }

        return $response;
    }

    private  function uniqAction($name,$mail,$phone,$credit)
    {
        $json = array();

        $mrepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $res = $mrepo->findByName($name);
        if (!empty($res))
            $json['name'] = $name;


        $res = $mrepo->findByEmail($mail);
        if (!empty($res))
            $json['email'] = $mail;

        $res = $mrepo->findByPhone($phone);
        if (!empty($res))
            $json['phone'] = $phone;

        $res = $mrepo->findByCredit($credit);
        if (!empty($res))
            $json['credit'] = $credit;

        return $json;
    }

    /**
     * @Route("/allUser/{uname}/{pswd}")
     */
    public function allAction($uname,$pswd){

        $urepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $urepo->findAll();
        $users = array();
        for($i = 0 ; $i<count($user) ;$i++) {
            array_push($users, $this->createUser($user[$i]));
        }
        $response = new JsonResponse();
        $response->setData(array('response'=>array('profile'=>$users)));


        return $response;
    }

    /**
     * @Route("/upDate/{id}/{date}")
     */
    function updateAction($id,$date){
        $query = "UPDATE user SET PayDay='$date' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    /**
     * @Route("/upEmail/{id}/{email}")
     */
    function upemailAction($id,$email){
        $query = "UPDATE user SET email='$email' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }

    /**
     * @Route("/upPswd/{id}/{pswd}")
     */
    function upPswdAction($id,$pswd){
        $query = "UPDATE user SET password='$pswd' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    /**
     * @Route("/upName/{id}/{name}")
     */
    function upNameAction($id,$name){
        $query = "UPDATE user SET name='$name' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    /**
     * @Route("/upPhone/{id}/{phone}")
     */
    function upTelephoneAction($id,$phone){
        $query = "UPDATE user SET phone='$phone' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    /**
     * @Route("/upCredit/{id}/{credit}")
     */
    function upCreditAction($id,$credit){
        $query = "UPDATE user SET credit='$credit' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    /**
     * @Route("/upStatus/{id}/{status}")
     */
    function upStatusAction($id,$status){
        $query = "UPDATE user SET status='$status' WHERE id=$id;";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }

    private function createUser($my_user){

       // $date = $my_user->getPayday();
        $ar =  array(
            'id'        =>  $my_user->getId(),
            'name'      =>  $my_user->getName(),
            'password'  =>  $my_user->getPassword(),
            'mail'      =>  $my_user->getEmail(),
            'age'       =>  "21",
            'phone'     =>  $my_user->getPhone(),
            'statuswork'=>  $my_user->getStatus(),
            'payday'    =>  "2015-13-2",
            'total'     =>  $my_user->getTotal(),
            'credit'    =>  $my_user->getCredit(),
            'picpath'   =>  $my_user->getPicPath()
        );
        return $ar;
    }

    private function getQuery($query){
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        //return $statement->fetchAll();

    }
}
?>