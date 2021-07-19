<?php

declare(strict_types=1);

namespace App\UseCase\Entities;

class DeviceList
{
    /**
     * @var Device[]
     */
    private array $deviceList = [];

    /**
     * @return []
     */
    public function getDeviceList(): array
    {
        return $this->deviceList;
    }

    /**
     * @param Device[] $deviceList
     */
    public function setDeviceList(array $deviceList): void
    {
        $this->deviceList = $deviceList;
    }
}
