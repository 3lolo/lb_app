<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/upload/{email}/{name}")
     */
    public function updateImgAction($email,$name){
        $name = "http://www.pixel.kh.ua/application/web/images/".$name;
        $query = "UPDATE user SET picpath='$name' WHERE email='$email';";
        $this->getQuery($query);
        $response = new Response(
            '',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $response;
    }
    private function getQuery($query){
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        //return $statement->fetchAll();

    }
}
