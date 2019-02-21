<?php

namespace CivicPlus\Classes;

require_once('./CivicPlus/Classes/api_consumer.class.php');

use CivicPlus\Configuration;
use CivicPlus\Classes\APIConsumer;

/**
 *      Authentication
 *      @author Donny Hansen
 */
class Authentication extends APIConsumer {

    const ENDPOINT = '/api/Auth';
    
    public function __construct() {
        parent::__construct();
    }

    /**
     *      getAccessToken
     *      @param string $clientId String representing the client id.
     *      @param string $clientSecret String representing the client password.
     *      @return json Provides the access_token and expires_in params from API.
     */
    public function getAccessToken(String $clientId, String $clientSecret) {
        $data = [
            'query' => [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret
            ]
        ];
        $response = $this->send('POST', Configuration::RequestUrlPrefix . self::ENDPOINT, $data);

        // Store the token to be used in other API calls
        // Need to put this in the $_SESSION

        return json_encode([
            'access_token' => $response->access_token,
            'expires_in' => $response->expires_in
        ]);
    }

}