<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeviceControllerTest extends WebTestCase
{
    public function testGetDeviceList()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/device');
        $response = $client->getResponse()->getContent();

        $expectedString = '[{"device_id":9025,"device_type":"Smartphone","damage_possible":true},{"device_id":9026,"device_type":"Smartwatch","damage_possible":true},{"device_id":97,"device_type":"Tablet","damage_possible":true},{"device_id":30,"device_type":"Notebook","damage_possible":true},{"device_id":123,"device_type":"Kaffeemaschine","damage_possible":false}]';

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString($expectedString, $response);
    }

    public function testGetDeviceWithReturnsTrue()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/device/9025');
        $response = $client->getResponse()->getContent();
        $expectedString = '{"device_id":9025,"device_type":"Smartphone","damage_possible":true}';

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonStringEqualsJsonString($expectedString, $response);
    }

    public function testGetDeviceWithReturnsDeviceNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/device/888888');
        $response = $client->getResponse()->getContent();
        $expectedString = 'Device not found';

        $this->assertResponseStatusCodeSame(404);
    }
}
