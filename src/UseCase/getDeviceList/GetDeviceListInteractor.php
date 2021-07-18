<?php

namespace App\UseCase\getDeviceList;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\DeviceList;
use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

class GetDeviceListInteractor
{
    /** @var DeviceRepository */
    private $repository;

    /** @var DeviceRepository */
    private $presenter;

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
