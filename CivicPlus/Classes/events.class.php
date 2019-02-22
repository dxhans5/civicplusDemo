<?php

namespace CivicPlus\Classes;

require_once('./CivicPlus/Classes/api_consumer.class.php');

use CivicPlus\Configuration;
use CivicPlus\Classes\APIConsumer;

/**
 *      Events
 *      @author Donny Hansen
 */
class Events extends APIConsumer {

    const ENDPOINT = '/api/Events';
    
    public function __construct() {
        parent::__construct();
    }

    public function addEvent(String $title, String $desc, String $start, String $end) {
        $data = [
            'headers' => [
                'Authorization' => $_SESSION['token']
            ],
            'json' => [
                'title' => $title,
                'description' => $desc,
                'startDate' => $start,
                'endDate' => $end
            ]
        ];

        return json_encode($this->send('POST', Configuration::RequestUrlPrefix . self::ENDPOINT, $data));
    }

    public function getEvents(Array $options = null) {
        $data = [
            'headers' => [
                'Authorization' => $_SESSION['token']
            ]
        ];

        if(!empty($options)) {
            foreach($options as $optionKey => $optionVal) {
                $data['json'][$optionKey] = $optionVal;
            }
        }

        return json_encode($this->send('GET', Configuration::RequestUrlPrefix . self::ENDPOINT, $data));   
    }

    public function getEvent(String $eventID) {
        $data = [
            'headers' => [
                'Authorization' => $_SESSION['token']
            ]
        ];

        return json_encode($this->send('GET', Configuration::RequestUrlPrefix . self::ENDPOINT . '/' . $eventID, $data));   
    }

    

}