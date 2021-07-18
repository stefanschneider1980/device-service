<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\UseCase\Entities\Device;
use PHPUnit\Framework\TestCase;

class CsvDeviceRepositoryTest extends TestCase
{
    /** @var CsvDeviceRepository */
    private CsvDeviceRepository $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepository();
    }

    public function testInstanciated()
    {
        $this->assertInstanceOf(DeviceRepository::class, new CsvDeviceRepository());
    }

    public function testGetDeviceReturnsCorrectDevice(): void
    {
        $device = new Device();
        $device->setDeviceId(9000)
               ->setDeviceType('Smartphone')
               ->setDamagePossible(true);

        $this->assertEquals($device, $this->repository->getDevice());
    }
}
