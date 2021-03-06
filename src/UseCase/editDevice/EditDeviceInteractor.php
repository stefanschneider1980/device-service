<?php

namespace App\UseCase\editDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;
use stdClass;
use Throwable;

class EditDeviceInteractor
{
    /** @var DeviceRepository */
    private DeviceRepository $repository;

    /**
     * @param DeviceRepository $repository
     */
    public function __construct(CsvDeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(stdClass $editDeviceRequest): bool
    {
        $device = new Device();
        $device->setDeviceId((int)$editDeviceRequest->deviceId);
        $device->setDeviceType($editDeviceRequest->deviceType);
        $device->setDamagePossible($editDeviceRequest->isDamagePossible);

        try {
            return $this->repository->editDevice($device);
        } catch (Throwable $exception) {
            return false;
        }
    }
}
