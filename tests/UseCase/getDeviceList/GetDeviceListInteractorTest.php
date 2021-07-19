<?php

declare(strict_types=1);

namespace App\Tests\UseCase\getDeviceList;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\Entities\Device;
use App\UseCase\Entities\DeviceList;
use App\UseCase\getDeviceList\GetDeviceListInteractor;
use Exception;
use PHPUnit\Framework\TestCase;

class GetDeviceListInteractorTest extends TestCase
{
    /** @var GetDeviceListInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy('foobar');
        $this->interactor = new GetDeviceListInteractor($this->repository);
    }

    public function testExecute(): void
    {
        $device = new Device();
        $device->setDeviceId(9000)
            ->setDeviceType('Smartphone')
            ->setDamagePossible(true);

        $deviceList = new DeviceList();
        $deviceList->setDeviceList([$device]);

        $result = $this->interactor->execute();

        $this->assertSame(1, $this->repository->countOfCallsOfGetDeviceList);
        $this->assertEquals($result, $deviceList->getDeviceList());
    }

    public function testExecuteThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error');

        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('getDeviceList')
            ->will($this->throwException(new Exception('Error')));
        $interactor = new GetDeviceListInteractor($repository);

        $interactor->execute();
    }
}
