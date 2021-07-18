<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\DeviceNotFoundException;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use Symfony\Component\Config\Definition\Exception\Exception;

class CsvDeviceRepository implements DeviceRepository
{
    private string $projectPath;

    /**
     * CsvDeviceRepository constructor.
     */
    public function __construct(string $directory_path)
    {
        $this->projectPath = $directory_path;
    }

    /**
     * @return DeviceList
     */
    public function getDeviceList(): DeviceList
    {

        $deviceList = new DeviceList();

        try {
            $reader = Reader::createFromPath($this->projectPath . '/src/data/devices.csv', 'r');
            $reader->setHeaderOffset(0);
            $reader->setDelimiter(';');
            $records = Statement::create()->process($reader);
            $records->getHeader();

            $list = [];

            foreach ($records as $record) {
                $device = new Device();
                $device->setDeviceId((int)$record['device_id'])
                    ->setDeviceType($record['device_type'])
                    ->setDamagePossible((bool)$record['damage_possible']);

                $list[] = $device;
            }

            $deviceList->setDeviceList($list);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }

        return $deviceList;
    }

    /**
     * @return Device
     */
    public function getDevice($deviceNumber): Device
    {
        $device = new Device();

        $reader = Reader::createFromPath($this->projectPath . '/src/data/devices.csv', 'r');
        $reader->setHeaderOffset(0);
        $reader->setDelimiter(';');
        $records = Statement::create()->process($reader);
        $records->getHeader();

        $device = new Device();

        foreach ($records as $record) {
            if ($record['device_id'] === $deviceNumber) {
                $device = new Device();
                $device->setDeviceId((int)$record['device_id'])
                    ->setDeviceType($record['device_type'])
                    ->setDamagePossible((bool)$record['damage_possible']);
            }
        }

        if ($device->getDeviceId() === 0) {
            throw new DeviceNotFoundException('Device not found');
        }

        return $device;
    }

    public function addDevice(array $entryList): bool
    {
        try {
            $header = ['damage_id', 'damage_type', 'damage_possible'];

            $writer = Writer::createFromPath($this->projectPath . '/src/data/test.csv', 'w+');
            $writer->setDelimiter(';');
            $writer->insertOne($header);

            foreach ($entryList as $entry) {
                $writer->insertOne($entry);
            }

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function editDevice(): bool
    {
        // TODO: Implement editDevice() method.
    }

    public function deleteDevice(): bool
    {
        // TODO: Implement deleteDevice() method.
    }
}
