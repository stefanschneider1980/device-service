<?php

namespace App\UseCase\deleteDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use Throwable;

class DeleteDeviceInteractor
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

    public function execute(int $deviceId): bool
    {
        try {
            return $this->repository->deleteDevice($deviceId);
        } catch (Throwable $exception) {
            return false;
        }
    }
}
