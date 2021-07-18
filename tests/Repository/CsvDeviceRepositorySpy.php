<?php

namespace App\Tests\Repository;

use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;

class CsvDeviceRepositorySpy implements DeviceRepository
{
    /**
     * @var int
     */
    public $countOfCallsOfGetDevice = 0;
    public $countOfCallsOfGetDeviceList = 0;

    public function getDeviceList(): DeviceList
    {
        $this->countOfCallsOfGetDeviceList++;

        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        $deviceList = new DeviceList();
        $deviceList->setDeviceList([$device]);

        return $deviceList;
    }

    public function getDevice(): Device
    {
        $this->countOfCallsOfGetDevice++;

        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        return $device;
    }

    public function addDevice(): bool
    {
        // TODO: Implement addDevice() method.
    }

    public function editDevice(): bool
    {
        // TODO: Implement editDevice() method.
    }

    public function deleteDevice(): bool
    {
        // TODO: Implement deleteDevice() method.
    }
}
