<?php

declare(strict_types=1);

namespace App\Tests\UseCase\deleteDevice;

use App\Repository\CsvDeviceRepository;
use App\Repository\DeviceRepository;
use App\Tests\Repository\CsvDeviceRepositorySpy;
use App\UseCase\deleteDevice\DeleteDeviceInteractor;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

class DeleteDeviceInteractorTest extends TestCase
{
    /** @var DeleteDeviceInteractor */
    private $interactor;

    /** @var DeviceRepository */
    private $repository;

    public function setUp(): void
    {
        $this->repository = new CsvDeviceRepositorySpy('foobar');
        $this->interactor = new DeleteDeviceInteractor($this->repository);
    }

    public function testExecuteReturnsTrue(): void
    {
        $result = $this->interactor->execute(15);

        $this->assertSame(1, $this->repository->countOfCallsOfDeleteDevice);
        $this->assertTrue($result);
    }

    public function testExecuteReturnsFalse(): void
    {
        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('deleteDevice')
            ->with(9000)
            ->will($this->returnValue(false));
        $interactor = new DeleteDeviceInteractor($repository);

        $result = $interactor->execute(9000);

        $this->assertFalse($result);
    }

    public function testExecuteReturnsFalseIfExceptionIsThrown(): void
    {
        $repository = $this->getMockBuilder(CsvDeviceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('deleteDevice')
            ->with(9000)
            ->will($this->throwException(new Exception('Error')));
        $interactor = new DeleteDeviceInteractor($repository);

        $result = $interactor->execute(9000);

        $this->assertFalse($result);
    }
}
