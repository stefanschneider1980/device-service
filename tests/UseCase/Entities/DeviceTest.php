<?php

namespace App\Tests\UseCase\Entities;

use App\UseCase\Entities\Device;
use PHPUnit\Framework\TestCase;

class DeviceTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $device = new Device();
        $device->setDeviceId(15);
        $device->setDeviceType('Testcase');
        $device->setDamagePossible(true);

        $this->assertSame(15, $device->getDeviceId());
        $this->assertSame('Testcase', $device->getDeviceType());
        $this->assertTrue($device->isDamagePossible());
    }

    public function testSerializeReturnsCorrectData()
    {
        $device = new Device();
        $device->setDeviceId(815);
        $device->setDeviceType('Testcase');
        $device->setDamagePossible(true);

        $expectedResult = [
            'device_id' => 815,
            'device_type' => 'Testcase',
            'damage_possible' => true
        ];

        $this->assertEquals($expectedResult, $device->jsonSerialize());
    }
}
