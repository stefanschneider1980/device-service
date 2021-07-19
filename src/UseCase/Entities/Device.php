<?php

declare(strict_types=1);

namespace App\UseCase\Entities;

class Device implements \JsonSerializable
{
    /**
     * @var int
     */
    private $deviceId = 0;

    /**
     * @var string
     */
    private $deviceType;

    /**
     * @var bool
     */
    private $damage_possible;

    /**
     * @return int
     */
    public function getDeviceId(): int
    {
        return $this->deviceId;
    }

    /**
     * @param int $deviceId
     */
    public function setDeviceId(int $deviceId): Device
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceType(): string
    {
        return $this->deviceType;
    }

    /**
     * @param string $deviceType
     */
    public function setDeviceType(string $deviceType): Device
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDamagePossible(): bool
    {
        return $this->damage_possible;
    }

    /**
     * @param bool $damage_possible
     */
    public function setDamagePossible(bool $damage_possible): Device
    {
        $this->damage_possible = $damage_possible;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'device_id' => $this->getDeviceId(),
            'device_type' => $this->getDeviceType(),
            'damage_possible' => $this->isDamagePossible()
        ];
    }
}
