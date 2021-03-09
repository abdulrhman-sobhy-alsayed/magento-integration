<?php

namespace PocketUp\User\Observer;

use Magento\Setup\Exception;
use PocketUp\User\Helper\PocketUpData;

class HandleLogoutEvent implements \Magento\Framework\Event\ObserverInterface
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

        $this->curl->setOption(CURLOPT_HEADER, 0);
        $this->curl->setOption(CURLOPT_TIMEOUT, 60);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);

        $api_key=$this->pocketUpData->getGeneralConfig('api_kay');
        $event=$this->pocketUpData->getGeneralConfig('event_type');

        if ($api_key){

            if ($event === 'logout'){
                $this->logoutEvent($api_key);
            }
        }
        else{
            $this->curl->get('http://127.0.0.1:3000/?status=undefined_api_key');
        }

        return $this;
    }


    private function logoutEvent($api_key){
        $this->curl->get('http://127.0.0.1:3000/?status=logout&api_key='.$api_key);
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
