<?php

namespace App\UseCase\deleteDevice;


use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;

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
            $actualEntries = $this->repository->getDeviceList()->getDeviceList();
            $entryList = [];

            /** @var Device $entry */
            foreach ($actualEntries as $entry) {
                $isDamagePossible = ($entry->isDamagePossible()) ? 1 : 0;
                $entryList[] = [$entry->getDeviceId(), $entry->getDeviceType(), $isDamagePossible];
            }

            //delete new Lin

            return $this->repository->addDevice($entryList);

        } catch (\Throwable $exception) {
            return false;
        }
    }
}
