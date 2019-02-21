<?php

namespace CivicPlus\Classes;

/** I would normally rely on an autoloader library to do this sort of thing **/
require_once('./vendor/autoload.php');
require_once('./CivicPlus/configuration.php');
require_once('./CivicPlus/Classes/authentication.class.php');

use CivicPlus\Configuration;
use GuzzleHttp\Client;

/**
 *      APIConsumer
 *      @author Donny Hansen
 */
abstract class APIConsumer {
    private static $instance;

    protected $client;
    protected $token;

    public function __construct() {
        $this->client = new Client(['base_uri' => Configuration::Domain . Configuration::RequestUrlPrefix]);
    }

    // Singleton
    final public static function getInstance(){
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass])) {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }

    protected function setToken(String $token) {
        $this->token = $response->access_token;
    }

    protected function send(String $method, String $url, Array $data) {
        print_r("Token: " . $this->token);
        switch($method) {
            case 'POST':
                $response = $this->client->post($url, $data);
                break;
            case 'GET':
            default:
                $response = $this->client->get($url, $data);
                break;
        }

        return json_decode($response->getBody());
    }

}