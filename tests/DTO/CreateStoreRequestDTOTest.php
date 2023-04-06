<?php 

namespace App\Tests\DTO;

use App\DTO\CreateStoreRequestDTO;
use PHPUnit\Framework\TestCase;

class CreateStoreRequestDTOTest extends TestCase
{
    public function testCreateStoreRequestDTO(): void
    {
        $name = 'My Store';
        $latitude = 48.858093;
        $longitude = 2.294694;
        $address = 'Champ de Mars, 5 Avenue Anatole France';
        $zipCode = '75007';
        $city = 'Paris';
        $managerId = 1;

        $dto = new CreateStoreRequestDTO(
            $name,
            $latitude,
            $longitude,
            $zipCode,
            $address,
            $city,
            $managerId
        );

        $this->assertSame($name, $dto->name);
        $this->assertSame($latitude, $dto->latitude);
        $this->assertSame($longitude, $dto->longitude);
        $this->assertSame($address, $dto->address);
        $this->assertSame($zipCode, $dto->zipCode);
        $this->assertSame($city, $dto->city);
        $this->assertSame($managerId, $dto->managerId);
    }

}
