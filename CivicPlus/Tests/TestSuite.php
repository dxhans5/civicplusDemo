<?php

namespace CivicPlus\Tests;

/** I would normally rely on an autoloader library to do this sort of thing **/
require_once('./vendor/autoload.php');
require_once('./CivicPlus/configuration.php');
require_once('./CivicPlus/Classes/authentication.class.php');
require_once('./CivicPlus/Classes/events.class.php');

use CivicPlus\Configuration;
use CivicPlus\Classes\Authentication;
use CivicPlus\Classes\Events;
use PHPUnit\Framework\TestCase;

final class TestSuite extends TestCase {

    private $token;

    public function testObtainAccessToken(){
        $authentication = Authentication::getInstance();
        $result = json_decode($authentication->getAccessToken(Configuration::HcmsClientId, Configuration::HcmsClientSecret));

        $this->assertObjectHasAttribute('access_token', $result);
        $this->assertObjectHasAttribute('expires_in', $result);
        $this->assertNotEmpty($result->access_token);
        $this->assertNotEmpty($result->expires_in);
    }

    public function testAddEventSuccess(){
        $data = [
            'title' => 'Test Event One',
            'desc' => 'This is the description for the first test event',
            'start' => '2019-06-02 12:00:00',
            'end' => '2019-06-02 20:00:00'
        ];

        $events = Events::getInstance();
        $result = json_decode($events->addEvent($data['title'], $data['desc'], $data['start'], $data['end']));
        print_r($result);
    }
}