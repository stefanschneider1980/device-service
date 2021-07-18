<?php

declare(strict_types=1);

namespace App\Tests\UseCase\getDevice;

use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\Entities\Device;
use App\UseCase\getDevice\GetDeviceInteractor;
use PHPUnit\Framework\TestCase;

class GetDeviceInteractorTest extends TestCase
{
    /** @var GetDeviceInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy();
        $this->interactor = new GetDeviceInteractor($this->repository);
    }

    public function testExecute()
    {
        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        $result = $this->interactor->execute();

        $this->assertSame(1, $this->repository->countOfCallsOfGetDevice);
        $this->assertEquals($result, $device);
    }
}
