<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.12.15
 * Time: 15:16
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query\ResultSetMapping;


class MessagesController extends Controller
{
    /**
     * @Route("/addMess/{from}/{to}/{mes}")
     */
    public function addAction($from,$to,$mes)
    {
        $message = new Message();
        $message->setFromId($from);
        $message->setToId($to);
        $message->setMessage($mes);
        $message->setStatus(0);
        $message->setDateTime(new \DateTime("now"));
        $date  = new \DateTime("now");
        $date->format('Y-m-d h-m-s');

        print_r($date);
        $mrepo = $this->getDoctrine()->getManager();

        $mrepo->persist($message);
        $mrepo->flush();
        return new Response();
    }

    /**
     * @Route("/getMess/{id}")
     */
    public function getAction($id)
    {
        $query = "SELECT messages.id,receiver.id, receiver.nick_name as to_id ,messages.message, sender.nick_name as from_id, messages.date_time ".
                 "FROM messages ".
                 "INNER JOIN user as sender ".
                 "ON sender.id = messages.from_id ".
                 "INNER JOIN user as receiver ".
                 "ON receiver.id = messages.to_id ".
                 "WHERE receiver.id = $id or sender.id = $id ".
                 "ORDER BY date_time DESC ";

     //   echo $query;
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();

        $response = new JsonResponse();
        $response->setData($results);//array('response'=>$mes_array));

        return $response;
    }
    /*
    public function getAction($id)
    {
        $mrepo = $this->getDoctrine()->getRepository('AppBundle:Message');
        $result = array();

        $messages  = $mrepo->findByFromId($id,array('date_time' => 'DESC'));
        $result = $this->addMessages($messages,$result);

        $messages  = $mrepo->findByToId($id,array('date_time' => 'DESC'));
        $result = $this->addMessages($messages,$result);


        // $mes_array = array("messages"=>$result);
        $response = new JsonResponse();
        $response->setData($result);//array('response'=>$mes_array));

        return $response;
    }
*/

    /**
     * @Route("/countMess/{id}")
     */
    public function countAction($id){
        $query = "SELECT email,Count(*) As cnt From user, messages ".
                 "WHERE messages.from_id = user.id AND messages.status=0 ".
                 "group by user.email";

        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $arr = array();
        for($i = 0 ;$i<count($results);$i++){
            $node = array("email"      =>  $results[$i]['email'],
                          "count"   =>  $results[$i]['cnt']);
            array_push($arr,$node);
        }


        $response = new JsonResponse();
        $response->setData(array('response'=>array('profile'=>$arr)));
        return $response;
/*
        SELECT `from_id`,Count(*)From messages
             WHERE `to_id` = 1 AND `status`=0
             group by `from_id`
*/
        //$tags = $qb->getQuery()->getResult();
    }
    /**
     * @Route("/readMess/{id}")
     */
    public function readAction($id){

        $query = "UPDATE messages SET status = 1 ".
            "WHERE messages.from_id = $id";


        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();



        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    private function addMessages($messages,$result){
        for($i = 0;$i < count($messages); $i++){
            $row =array("from"=>$messages[$i]       ->  getFromId(),
                        "to"=>$messages[$i]         ->  getToId(),
                        "message"=>$messages[$i]    ->  getMessage(),
                        "date"=>$messages[$i]       ->  getDateTime()->format('Y-m-d'),
                        "status"=>$messages[$i]     ->  getStatus()
            );
            array_push($result,$row);
        }
        return $result;
    }
    private function getQuery($query){
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        print_r($statement);
        //return $statement;

    }

}