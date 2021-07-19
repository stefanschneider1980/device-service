<?php

namespace App\UseCase\addDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;
use stdClass;
use Throwable;

class AddDeviceInteractor
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

    /**
     * @param stdClass $addDeviceRequest
     * @return bool
     */
    public function execute(stdClass $addDeviceRequest): bool
    {
        $newDevice = new Device();
        $newDevice->setDeviceId((int)$addDeviceRequest->deviceId);
        $newDevice->setDeviceType($addDeviceRequest->deviceType);
        $newDevice->setDamagePossible($addDeviceRequest->isDamagePossible);

        try {
            return $this->repository->addDevice($newDevice);
        } catch (Throwable $exception) {
            return false;
        }
    }
}
