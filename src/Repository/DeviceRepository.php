<?php

declare(strict_types=1);

namespace App\Repository;

use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;

interface DeviceRepository
{
    /**
     * @return DeviceList
     */
    public function getDeviceList(): DeviceList;

    /**
     * @return Device
     */
    public function getDevice($deviceNumber): Device;

    /**
     * @return bool
     */
    public function addDevice(array $entryList): bool;

    /**
     * @return bool
     */
    public function editDevice(): bool;

    /**
     * @return bool
     */
    public function deleteDevice(): bool;
}
