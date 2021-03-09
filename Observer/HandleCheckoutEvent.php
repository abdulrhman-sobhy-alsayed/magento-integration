<?php

namespace PocketUp\User\Observer;

use Magento\Setup\Exception;
use PocketUp\User\Helper\PocketUpData;

class HandleCheckoutEvent implements \Magento\Framework\Event\ObserverInterface
{
    private $curl;
    private $pocketUpData;

    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl,
        PocketUpData $pocketUpData

    )
    {
        $this->curl=$curl;
        $this->pocketUpData=$pocketUpData;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $api_key=$this->pocketUpData->getGeneralConfig('api_kay');
        $earnAt=$this->pocketUpData->getGeneralConfig('earn_at');
        $burnAt=$this->pocketUpData->getGeneralConfig('burn_at');

        $this->curl->setOption(CURLOPT_HEADER, 0);
        $this->curl->setOption(CURLOPT_TIMEOUT, 60);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->addHeader("Authorization", "Api-Key ".$api_key);



        $orderStatus = $observer->getOrder()->getStatus();

        if ($api_key){

            if ($orderStatus === $earnAt) {
                $this->earnPoints($api_key, $observer);
            }
            elseif ($orderStatus === $burnAt){
                $this->burnPoints($api_key,$observer);
            }
        }

        return $this;
    }

    private function earnPoints($api_key,$observer){

        $order = $observer->getOrder();
        $data = $order->getData();
        $id= $order->getIncrementId();
        $amount= $order->getBaseTotalDue();

        $params= json_encode(array("amount"=>$amount,"invoice"=>$id,"raw"=>[$data]));
        $this->curl->post('http://localhost:4040/api/v1/online/customers/966/591234567/earn',$params);
//        $this->curl->post('http://localhost:3000/customer',$params);
    }

    private function burnPoints($api_key,$observer){

        $order = $observer->getOrder();
        $data = $order->getData();
        $id= $order->getIncrementId();
        $amount= $order->getBaseTotalDue();

        $params= json_encode(array("amount"=>$amount,"invoice"=>$id,"raw"=>[$data]));
//        $this->curl->post('http://localhost:4040/api/v1/online/customers/966/591234567/earn',$params);
        $this->curl->post('http://localhost:3000/burnPoints',$params);
    }
}


//        $username = 'admin';
//        $password = 'Aa@0507020813';
//      $this->curl->setOption(CURLOPT_USERPWD, $username . ":" . $password);


//                $URL = 'http://127.0.0.1:3000/customer';
//
//                $displayText = $observer->getCustomer()->getData();
//                $params = json_encode(array($displayText));
//
//                $this->curl->addHeader("Content-Type", "application/json");
//
//                $this->curl->post($URL, $params);

//        $this->curl->get('http://127.0.0.1:3000/?status=checkout&api_key='.$api_key);

//        $data=$order->getState();

//        $this->curl->get('http://127.0.0.1:3000/?status=kll');


//        $event=$this->pocketUpData->getGeneralConfig('event_type');


//        $displayText= $this->statuses->create()->toOptionArray();
//        $params = json_encode(array($data));

//        $this->curl->addHeader("Content-Type", "application/json");

//        $this->curl->post($URL, $params);

//        $URL = 'http://127.0.0.1:3000/customer';


//$this->curl->addHeader("Content-Type", "application/json");
//        $URL = 'http://127.0.0.1:3000/customer';
//        $this->curl->post($URL, $params);
