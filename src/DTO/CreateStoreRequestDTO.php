<?php

namespace App\DTO;


class CreateStoreRequestDTO
{

    public $name;
    public $latitude;
    public $longitude;
    public $zipCode;
    public $address;
    public $city;
    public $managerId;

    public function __construct(
        string $name,
        float $latitude,
        float $longitude,
        string $zipCode,
        string $address,
        string $city,
        int $managerId
    ) {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->zipCode = $zipCode;
        $this->address = $address;
        $this->city = $city;
        $this->managerId = $managerId;
    }
}
