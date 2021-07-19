<?php

namespace App\Tests\UseCase\Entities;

use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;
use PHPUnit\Framework\TestCase;

class DeviceListTest extends TestCase
{
    public function testSetterAndGetter()
    {
        $device = new Device();
        $device->setDeviceId(815);
        $device->setDeviceType('Testcase');
        $device->setDamagePossible(true);

        $deviceList = new DeviceList();
        $deviceList->setDeviceList([$device]);
        $this->assertEquals([$device], $deviceList->getDeviceList());
    }
}
