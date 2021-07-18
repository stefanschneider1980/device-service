<?php

declare(strict_types=1);

namespace App\Tests\UseCase\getDeviceList;

use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;
use App\UseCase\getDeviceList\GetDeviceListInteractor;
use PHPUnit\Framework\TestCase;

class GetDeviceListInteractorTest extends TestCase
{
    /** @var GetDeviceListInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy();
        $this->interactor = new GetDeviceListInteractor($this->repository);
    }

    public function testExecute()
    {
        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        $deviceList = new DeviceList();
        $deviceList->setDeviceList([$device]);

        $result = $this->interactor->execute();

        $this->assertSame(1, $this->repository->countOfCallsOfGetDeviceList);
        $this->assertEquals($result, $deviceList);
    }
}
