<?php



namespace App\UseCase\addDevice;


use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;

class addDeviceInteractor
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

    public function execute(\stdClass $addDeviceRequest): bool
    {
        try {
            $actualEntries = $this->repository->getDeviceList()->getDeviceList();
            $entryList = [];

            /** @var Device $entry */
            foreach ($actualEntries as $entry) {
                $isDamagePossible = ($entry->isDamagePossible()) ? 1 : 0;
                $entryList[] = [$entry->getDeviceId(), $entry->getDeviceType(), $isDamagePossible];
            }

            //add new Line
            $isDamagePossible = ($addDeviceRequest->isDamagePossible) ? 1 : 0;
            $newLine = [$addDeviceRequest->deviceId, $addDeviceRequest->deviceType, $isDamagePossible];
            $entryList[] = $newLine;

            return $this->repository->addDevice($entryList);

        } catch (\Throwable $exception) {
            return false;
        }
    }
}
