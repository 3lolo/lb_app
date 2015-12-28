<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.15
 * Time: 13:16
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\BankPrivat;
use Symfony\Component\HttpFoundation\JsonResponse;


class PrivateBankController extends Controller
{
    private $url1 = "https://api.privatbank.ua/p24api/balance";
    private $url2 = "https://api.privatbank.ua/p24api/pay_pb";
    private $url3 = "https://api.privatbank.ua/p24api/pay_visa";

    /**
     * @Route("/checkSum/{id}")
     */
    public function checkAction($id)
    {
        $urepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $brepo = $this->getDoctrine()->getRepository('AppBundle:BankPrivat');
        $user = $urepo->findById($id);
        $user = $brepo->findByIdUser($user[0]->getId());
        $xml = $this->checkSumXML($user[0]->getPassword(),$user[0]->getMerchandId(),$user[0]->getCardNum());
        $result = $this->msoap($xml,$this->url1);
       // $xml = simplexml_load_string($xml);
        $result = simplexml_load_string($result);

        $data = $result->data->info->cardbalance;

        $response = new JsonResponse();
        $response->setData(array('response'=>json_encode($data)));
        return $response;
    }
    /**
     * @Route("/paymentPrivat/{id}/{to_id}/{amount}/{valuta}")
     */
    public function payPrivatAction($id,$to_id,$amount,$valuta)
    {
        $brepo = $this->getDoctrine()->getRepository('AppBundle:BankPrivat');
        $user = $brepo->findByIdUser($id)[0];
        $user_to = $brepo->findByIdUser($to_id)[0];

        $xml = $this->paymentPrivatXML($user->getPassword(),$user->getMerchandId(),$user_to->getCardNum(),$amount,$valuta);
        $result = $this->msoap($xml,$this->url2);

        $xml = simplexml_load_string($result);
        $data = $xml->data->payment->attributes();

        $response = new JsonResponse();
        $response->setData(array('response'=>json_encode($data)));

        return $response;

    }
    /**
     * @Route("/paymentVisa/{id}/{to_id}/{amount}/{valuta}")
     */
    public function payVisaAction($id,$to_id,$amount,$valuta)
    {
        $brepo = $this->getDoctrine()->getRepository('AppBundle:BankPrivat');
        $user = $brepo->findByIdUser($id)[0];
        $user_to = $brepo->findByIdUser($to_id)[0];

        $xml = $this->paymentVisaXML($user->getPassword(),$user->getMerchandId(),$user_to->getCardNum(),$amount,$user_to->getFio(),$valuta);
        $result = $this->msoap($xml,$this->url3);

        $xml = simplexml_load_string($result);
        $data = $xml->data->payment->attributes();

        $response = new JsonResponse();
        $response->setData(array('response'=>json_encode($data)));

        return $response;
    }

    private function checkSumXML($password,$merchantId,$cardnum){

        $data = "<oper>cmt</oper>
    <wait>20</wait>
    <test>1</test>
    <payment id='1'>
        <prop name='cardnum' value='$cardnum'/>
        <prop name='country' value='UA'/>
    </payment>";
        $signature = sha1(md5($data.$password));
        $xml ="<request version='1.0'>
        <merchant>
            <id>$merchantId</id>
            <signature>$signature</signature>
        </merchant>
        <data>".$data."</data>
    </request>";
        return $xml;
    }

    private function paymentPrivatXML($password,$merchantId,$rcard,$amt,$valuta){
        $data = "<request version='1.0'>
    <oper>cmt</oper>
    <wait>30</wait>
    <test>1</test>
    <payment id='1'>
      <prop name='b_card_or_acc' value='$rcard' />
      <prop name='amt' value='$amt' />
      <prop name='ccy' value='$valuta' />
      <prop name='details' value='test%20merch%20not%20active' />
    </payment>";
        $signature = sha1(md5($data.$password));
        $xml="<request version='1.0'>
    <merchant>
      <id>$merchantId</id>
      <signature>$signature</signature>
    </merchant>
    <data>".$data."</data>
  </request>";

        return $xml;
    }

    private function paymentVisaXML($password,$merchantId,$rcard,$amt,$fio,$valuta){
       // echo fio;
        $data = "<oper>cmt</oper>
    <wait>30</wait>
    <test>1</test>
    <payment id='1'>
      <prop name='b_card_or_acc' value='$rcard'/>
      <prop name='amt' value='$amt' />
      <prop name='ccy'  value='$valuta' />
      <prop name='b_name' value='$fio' />
      <prop name='details' value='testVisa' />
    </payment>";
        $signature = sha1(md5($data.$password));

        $xml="<request version='1.0'>
    <merchant>
      <id>$merchantId</id>
      <signature>$signature</signature>
    </merchant>
    <data>".$data."</data>
  </request>";
        return $xml;
    }

    private function msoap($xml,$url) {
        $header = array();
        $header[] = "Content-Type: text/xml";
        $header[] = "\r\n";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $rez = curl_exec($ch);
        curl_close($ch);
        return $rez;
    }
}