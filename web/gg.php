<?php
echo "fin";
$password = "16Q946sCxj61G87X58n4sO0MS4MmFTAW";
$ucard = "4149437853450615";
$fio = "POZNIAK";
$merchantId = "114058";
$rcard = "5168742016300547";
$cmd = "paymentPrivat";
$valuta = "UAH";

switch ($cmd) {
  case 'checkSum':

    $xml = checkSumXML($password,$merchantId,$ucard);
    $url = "https://api.privatbank.ua/p24api/balance";
    $result  = msoap($xml,$url);
    //chekcResult($result);
    //$array_data = json_decode(json_encode(simplexml_load_string($result)), true);
   // print_r($result);
     //echo '<pre>', htmlentities($result), '</pre>';
    $xml = simplexml_load_string($result);
    $data = $xml->data->info;//->cardbalance;
    $info = array(  "balance"       =>  $data->$av_balance,
                    "date"          =>  $data->$bal_date,
                    "fin_limit"     =>  $data->$fin_limit,
                    "trade_limit"   =>  $data->$trade_limit);

    //echo $xml->data->cardnum;

    break;
  case 'paymentPrivat':
    $xml = paymentPrivatXML($password,$merchantId,$rcard,"20.0",$valuta);
    $url = "https://api.privatbank.ua/p24api/pay_pb";
      echo '<pre>', htmlentities($xml), '</pre>';
    break;
  case 'paymentVisa':
    $xml = paymentVisaXML($password,$merchantId,$rcard,20.0,$fio,$valuta);
    $url = "https://api.privatbank.ua/p24api/pay_visa";

    break;
}
$result  = msoap($xml,$url);

echo '<pre>', htmlentities($result), '</pre>';
echo "fin";

function msoap($xml,$url) {
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

function checkSumXML($password,$merchantId,$cardnum){
    
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

function paymentPrivatXML($password,$merchantId,$rcard,$amt,$valuta){
  $data = "
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

function paymentVisaXML($password,$merchantId,$rcard,$amt,$fio,$valuta){
    echo fio;
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

function checkResult($res){
    $data = json_decode(json_encode(simplexml_load_string($res)), true);
    print_r($data);
}
?>