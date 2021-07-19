<?php

declare(strict_types=1);

namespace App\Tests\UseCase\editDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\addDevice\AddDeviceInteractor;
use App\UseCase\editDevice\EditDeviceInteractor;
use App\UseCase\Entities\Device;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddDeviceInteractorTest extends TestCase
{
    /** @var EditDeviceInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy('foobar');
        $this->interactor = new EditDeviceInteractor($this->repository);
    }

    public function testExecuteReturnsTrue(): void
    {
        $device = $this->getDeviceRequest();

        $result = $this->interactor->execute($device);

        $this->assertSame(1, $this->repository->countOfCallsOfEditDevice);
        $this->assertTrue($result);
    }

    public function testExecuteReturnsFalse(): void
    {
        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('editDevice')
            ->with($this->getDevice())
            ->will($this->returnValue(false));

        $device = $this->getDeviceRequest();

        $interactor = new EditDeviceInteractor($repository);

        $result = $interactor->execute($device);

        $this->assertFalse($result);
    }

    public function testExecuteReturnsFalseIfExceptionIsThrown(): void
    {
        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('editDevice')
            ->with($this->getDevice())
            ->will($this->throwException(new Exception('Error')));
        $device = $this->getDeviceRequest();
        $interactor = new EditDeviceInteractor($repository);

        $result = $interactor->execute($device);

        $this->assertFalse($result);
    }

    /**
     * @return Device
     */
    public function getDevice(): Device
    {
        $newDevice = new Device();
        $newDevice->setDeviceId(9000);
        $newDevice->setDeviceType('Smartphone');
        $newDevice->setDamagePossible(true);

        return $newDevice;
    }

    /**
     * @return \stdClass
     */
    public function getDeviceRequest(): \stdClass
    {
        $device = new \stdClass();
        $device->deviceId = 9000;
        $device->deviceType = 'Smartphone';
        $device->isDamagePossible = true;
        return $device;
    }
}
