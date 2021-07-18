<?php

namespace App\UseCase\getDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;
use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

class GetDeviceInteractor
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

    public function execute($deviceNumber): Device
    {
        try {
            $result = $this->repository->getDevice($deviceNumber);

            return $result;
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
