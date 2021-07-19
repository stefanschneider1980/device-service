<?php

namespace App\Tests\Repository;

use App\Repository\CsvDeviceRepository;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;

class CsvDeviceRepositorySpy extends CsvDeviceRepository
{
    /** @var int */
    public $countOfCallsOfGetDevice = 0;

    /** @var int */
    public $countOfCallsOfGetDeviceList = 0;

    /** @var int */
    public $countOfCallsOfAddDevice = 0;

    /** @var int */
    public $countOfCallsOfEditDevice = 0;

    /** @var int */
    public $countOfCallsOfDeleteDevice = 0;

    /**
     * @return DeviceList
     */
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

    /**
     * @param $deviceNumber
     * @return Device
     */
    public function getDevice($deviceNumber): Device
    {
        $this->countOfCallsOfGetDevice++;

        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        return $device;
    }

    /**
     * @param Device $editDevice
     * @return bool
     */
    public function addDevice(Device $editDevice): bool
    {
        $this->countOfCallsOfAddDevice++;

        return true;
    }

    /**
     * @param Device $editDevice
     * @return bool
     */
    public function editDevice(Device $editDevice): bool
    {
        $this->countOfCallsOfEditDevice++;

        return true;
    }

    /**
     * @param string $deviceNumber
     * @return bool
     */
    public function deleteDevice(string $deviceNumber): bool
    {
        $this->countOfCallsOfDeleteDevice++;

        return true;
    }
}
