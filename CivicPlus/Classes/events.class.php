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
            'json' => [
                'title' => $title,
                'description' => $desc,
                'startDate' => $start,
                'endDate' => $end
            ]
        ];

        $response = $this->client->post(Configuration::RequestUrlPrefix . self::ENDPOINT, $data);
        $body = json_decode($response->getBody());
    }

    

}