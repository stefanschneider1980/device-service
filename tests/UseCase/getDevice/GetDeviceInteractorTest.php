<?php

declare(strict_types=1);

namespace App\Tests\UseCase\getDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\Entities\Device;
use App\UseCase\getDevice\GetDeviceInteractor;
use Exception;
use PHPUnit\Framework\TestCase;

class GetDeviceInteractorTest extends TestCase
{
    /** @var GetDeviceInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy('foobar');
        $this->interactor = new GetDeviceInteractor($this->repository);
    }

    public function testExecute()
    {
        $result = $this->interactor->execute(9000);

        $this->assertSame(1, $this->repository->countOfCallsOfGetDevice);
        $this->assertEquals($result, $this->getDevice());
    }

    public function testExecuteThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error');

        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('getDevice')
            ->with(9000)
            ->will($this->throwException(new Exception('Error')));
        $interactor = new GetDeviceInteractor($repository);

        $interactor->execute(9000);
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
}
