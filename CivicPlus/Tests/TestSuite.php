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
            'end' => '2019-06-03 20:00:00'
        ];

        $events = Events::getInstance();
        $result = json_decode($events->addEvent($data['title'], $data['desc'], $data['start'], $data['end']));
        
        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('title', $result);
        $this->assertObjectHasAttribute('description', $result);
        $this->assertObjectHasAttribute('startDate', $result);
        $this->assertObjectHasAttribute('endDate', $result);
        $this->assertEquals($result->title, $data['title']);
        $this->assertEquals($result->description, $data['desc']);
    }

    public function testListAllEvents(){
        $events = Events::getInstance();
        $result = json_decode($events->getEvents());
        
        $this->assertObjectHasAttribute('total', $result);
        $this->assertObjectHasAttribute('items', $result);
        $this->assertObjectHasAttribute('id', $result->items[0]);
        $this->assertObjectHasAttribute('title', $result->items[0]);
        $this->assertObjectHasAttribute('description', $result->items[0]);
        $this->assertObjectHasAttribute('startDate', $result->items[0]);
        $this->assertObjectHasAttribute('endDate', $result->items[0]);
    }

    public function testListSpecificEvent(){
        $events = Events::getInstance();
        $result = json_decode($events->getEvents());
        $testEventID = $result->items[0]->id;
        $result = json_decode($events->getEvent($testEventID));

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('title', $result);
        $this->assertObjectHasAttribute('description', $result);
        $this->assertObjectHasAttribute('startDate', $result);
        $this->assertObjectHasAttribute('endDate', $result);
        $this->assertEquals($testEventID, $result->id);
    }
}