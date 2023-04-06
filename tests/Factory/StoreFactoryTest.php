<?php 

namespace App\Tests\Factory;

use App\DTO\CreateStoreRequestDTO;
use App\Entity\Manager;
use App\Entity\Store;
use App\Factory\StoreFactory;
use App\Repository\ManagerRepository;
use PHPUnit\Framework\TestCase;

class StoreFactoryTest extends TestCase
{
    private StoreFactory $storeFactory;
    private ManagerRepository $managerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->managerRepository = $this->createMock(ManagerRepository::class);
        $this->storeFactory = new StoreFactory($this->managerRepository);
    }

    /**
     * function for testing with valid data
     *
     * @dataProvider provideValidCreateFromDTOData
     */
    public function testValidCreateFromDto (
        CreateStoreRequestDTO $createStoreRequestDTO,
        Manager $manager,
        Store $expectedResult
    ): void {
        $this->managerRepository
            ->expects($this->once())
            ->method('find')
            ->with($createStoreRequestDTO->managerId)
            ->willReturn($manager)
        ;

        $result = $this->storeFactory->createFromDto($createStoreRequestDTO);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideValidCreateFromDTOData(): array
    {
        $storeName = 'Store name';
        $storeLatitude = 48.856614;
        $storeLongitude = 2.3522219;
        $storeAddress = '10 Rue de la Paix';
        $storeZipCode = '75002';
        $storeCity = 'Paris';
        $storeManagerId = 1;

        $firtManager = new Manager('John', 'Doe');

        return [
            [
                new CreateStoreRequestDTO($storeName, $storeLatitude, $storeLongitude, $storeZipCode, $storeAddress, $storeCity, $storeManagerId),
                $firtManager,
                new Store($storeName, $storeLatitude, $storeLongitude, $storeAddress, $storeZipCode, $storeCity, $firtManager)
            ]
        ];
    }

    public function testValidateDataWithValidData(): void
    {
        $this->assertTrue(
            $this->storeFactory->validateData('store Name', 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe'))
        );
    }

    /**
     * @dataProvider invalidData
     */
    public function testValidateDataWithInvalidData($name, $latitude, $longitude, $address, $zipCode, $city, $manager): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->storeFactory->validateData($name, $latitude, $longitude, $address, $zipCode, $city, $manager);
    }

    public function invalidData(): iterable
    {
        yield 'empty store name' => [null, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'store name is not a string' => [2, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];  
        yield 'empty store latitude' => ['store name', null, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'store latitude is not a float' => ['store name', 'test', 2.3522219, '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];  
        yield 'empty store longitude' => ['store name', 48.856614, 'null', '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'store longitude is not a float' => ['store name', 48.856614, 'test', '10 Rue de la Paix', '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'empty store address' => ['store name', 48.856614, 2.3522219, null, '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'store address is not a string' => ['store name', 48.856614, 2.3522219, 3, '75002', 'Paris', new Manager('John', 'Doe')];
        yield 'empty store zipCode' => ['store name', 48.856614, 2.3522219, '10 Rue de la Paix', null, 'Paris', new Manager('John', 'Doe')];
        yield 'store zipCode is not a string' => ['store name', 48.856614, 2.3522219, '10 Rue de la Paix', 2, 'Paris', new Manager('John', 'Doe')]; 
        yield 'empty store city' => [null, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', null, new Manager('John', 'Doe')];
        yield 'store city is not a string' => [2, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 2, new Manager('John', 'Doe')];
        yield 'empty store Manager' => [null, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', null];
        yield 'store manager is not a Manager' => [2, 48.856614, 2.3522219, '10 Rue de la Paix', '75002', 'Paris', 'test'];
    }
}
