<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\DeviceNotFoundException;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use League\Csv\Writer;
use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

class CsvDeviceRepository implements DeviceRepository
{
    private const CSV_HEADER_KEYS = ['device_id', 'device_type', 'damage_possible'];

    /**
     * @var string
     */
    private string $projectPath;

    /**
     * @param string $directory_path
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
            $records = $this->readDataFromCsv();

            $list = [];

            foreach ($records as $record) {
                $device = new Device();
                $device->setDeviceId((int)$record['device_id'])
                    ->setDeviceType($record['device_type'])
                    ->setDamagePossible((bool)$record['damage_possible']);

                $list[] = $device;
            }

            $deviceList->setDeviceList($list);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }

        return $deviceList;
    }

    /**
     * @param $deviceNumber
     * @return Device
     * @throws DeviceNotFoundException
     * @throws InvalidArgument
     * @throws \League\Csv\Exception
     */
    public function getDevice($deviceNumber): Device
    {
        $records = $this->readDataFromCsv();

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

    public function addDevice(Device $newDevice): bool
    {
        $entryList = [];

        try {
            $actualEntryList = $this->readDataFromCsv();

            /** @var Device $entry */
            foreach ($actualEntryList as $entry) {
                $isDamagePossible = ($entry['damage_possible']) ? 1 : 0;
                $entryList[] = [$entry['device_id'], $entry['device_type'], $isDamagePossible];
            }
        } catch (Throwable $exception) {
            return false;
        }

        $isDamagePossible = ($newDevice->isDamagePossible()) ? 1 : 0;
        $newLine = [$newDevice->getDeviceId(), $newDevice->getDeviceType(), $isDamagePossible];
        $entryList[] = $newLine;

        try {
            $writer = Writer::createFromPath($this->projectPath . '/src/data/devices.csv', 'w+');
            $writer->setDelimiter(';');
            $writer->insertOne(self::CSV_HEADER_KEYS);

            foreach ($entryList as $entry) {
                $writer->insertOne($entry);
            }

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function editDevice(Device $editDevice): bool
    {
        $entryList = [];
        try {
            $actualCsvData = $this->readDataFromCsv();
            $list = [];

            foreach ($actualCsvData as $record) {
                $list[] = $record;
            }

            foreach ($list as $index => $row) {
                if ($row['device_id'] === (string)$editDevice->getDeviceId()) {
                    $isDamagePossible = ($editDevice->isDamagePossible()) ? 1 : 0;
                    $replacement = [
                        'device_id' => $editDevice->getDeviceId(),
                        'device_type' => $editDevice->getDeviceType(),
                        'damage_possible' => $isDamagePossible
                    ];
                    $list[$index] = $replacement;
                }
            }
            $dataToWrite = $this->prepareCsvWriteDataFromArray($list);

            return $this->writeDataToCsv($dataToWrite);
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function deleteDevice(string $deviceNumber): bool
    {
        $entryList = [];

        try {
            $actualCsvData = $this->readDataFromCsv();
            $isNumberFound = false;
            $list = [];

            foreach ($actualCsvData as $record) {
                $list[] = $record;
            }

            foreach ($list as $index => $row) {
                if ($row['device_id'] === $deviceNumber) {
                    unset($list[$index]);
                    $isNumberFound = true;
                }
            }

            if ($isNumberFound) {
                $dataToWrite = $this->prepareCsvWriteDataFromArray($list);

                return $this->writeDataToCsv($dataToWrite);
            }

            return false;
        } catch (Throwable $exception) {
            return false;
        }
    }

    /**
     * @return TabularDataReader
     * @throws \League\Csv\Exception
     * @throws InvalidArgument
     */
    private function readDataFromCsv(): TabularDataReader
    {
        $reader = Reader::createFromPath($this->projectPath . '/src/data/devices.csv', 'r');
        $reader->setHeaderOffset(0);
        $reader->setDelimiter(';');
        $records = Statement::create()->process($reader);
        $records->getHeader();

        return $records;
    }

    /**
     * @param $entryList
     * @return bool
     */
    public function writeDataToCsv(array $entryList): bool
    {
        try {
            $writer = Writer::createFromPath($this->projectPath . '/src/data/devices.csv', 'w+');
            $writer->setDelimiter(';');
            $writer->insertOne(self::CSV_HEADER_KEYS);

            foreach ($entryList as $entry) {
                $writer->insertOne($entry);
            }

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    /**
     * @return array
     * @throws InvalidArgument
     * @throws \League\Csv\Exception
     */
    public function prepareCsvWriteDataFromArray(array $list): array
    {
        $entryList = [];

        /** @var Device $entry */
        foreach ($list as $entry) {
            $isDamagePossible = ($entry['damage_possible']) ? 1 : 0;
            $entryList[] = [$entry['device_id'], $entry['device_type'], $isDamagePossible];
        }

        return $entryList;
    }
}
