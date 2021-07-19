<?php

namespace App\UseCase\getDeviceList;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;

class GetDeviceListInteractor
{
    /** @var DeviceRepository */
    private $repository;

    /**
     * @param DeviceRepository $repository
     */
    public function __construct(CsvDeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->getDeviceList()->getDeviceList();
    }
}
