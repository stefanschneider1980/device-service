<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeviceControllerTest extends WebTestCase
{
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

        $this->assertResponseStatusCodeSame(404);
    }

    public function testAddDeviceReturnsHttpStatusCodeCreated()
    {
        $testdata = [
            'deviceId'         => 25001,
            'deviceType'       => 'integrationTest',
            'isDamagePossible' => true
        ];

        $client = static::createClient();
        $client->request('POST', '/api/v1/device', array(), array(), array(), json_encode($testdata));

        $this->assertResponseStatusCodeSame(201);
    }

    public function testEditDeviceReturnsHttpStatusCodeOK()
    {
        $testdata = [
            'deviceId'         => 25001,
            'deviceType'       => 'editTest',
            'isDamagePossible' => true
        ];

        $client = static::createClient();
        $client->request('PUT', '/api/v1/device', array(), array(), array(), json_encode($testdata));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteDeviceReturnsHttpStatusCodeOK()
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/v1/device/25001');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetDeviceList()
    {
        var_dump(getenv('APP_ENV'));
        $client = static::createClient();
        $client->request('GET', '/api/v1/device');
        $response = $client->getResponse()->getContent();

        $expectedString = '[{"device_id":9025,"device_type":"Smartphone","damage_possible":true},{"device_id":9026,"device_type":"Smartwatch","damage_possible":true},{"device_id":97,"device_type":"Tablet","damage_possible":true},{"device_id":30,"device_type":"Notebook","damage_possible":true},{"device_id":123,"device_type":"Kaffeemaschine","damage_possible":false}]';

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString($expectedString, $response);
    }
}
