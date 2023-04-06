<?php

namespace App\Factory;

use App\DTO\CreateStoreRequestDTO;
use App\Entity\Manager;
use App\Entity\Store;
use App\Exception\ManagerNotFoundException;
use App\Repository\ManagerRepository;

class StoreFactory
{
    public function __construct(
        private readonly ManagerRepository $managerRepository
    ) {
        
    }

    protected function create(
        string $name, 
        float $latitude, 
        float $longitude, 
        string $address, 
        string $zipCode, 
        string $city, 
        Manager $manager
    ): Store {

        $this->validateData(
            $name,
            $latitude,
            $longitude,
            $address,
            $zipCode,
            $city,
            $manager
        );

        return new Store(
            $name,
            $latitude,
            $longitude,
            $address,
            $zipCode,
            $city,
            $manager
        );
    }

    public function createFromDto(CreateStoreRequestDTO $createStoreRequestDTO): Store {

        $manager = $this->managerRepository->find($createStoreRequestDTO->managerId);

        if (!$manager){
            throw new ManagerNotFoundException(sprintf('Manager with id "%d" not found', $createStoreRequestDTO->managerId));
        }

        $store = $this->create(
            $createStoreRequestDTO->name,
            $createStoreRequestDTO->latitude,
            $createStoreRequestDTO->longitude,
            $createStoreRequestDTO->address,
            $createStoreRequestDTO->zipCode,
            $createStoreRequestDTO->city,
            $manager
        );

        return $store;
    }

    public function validateData($name, $latitude, $longitude, $address, $zipCode, $city, $manager): bool
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Store name cannot be empty');
        }

        if (!is_string($name)) {
            throw new \InvalidArgumentException('Store name should be a string value');
        }
    
        if (empty($latitude)) {
            throw new \InvalidArgumentException('Store latitude cannot be empty');
        }

        if (!is_float($latitude)) {
            throw new \InvalidArgumentException('Latitude should be a float value');
        }
    
        if (!is_float($longitude)) {
            throw new \InvalidArgumentException('Longitude should be a float value');
        }

        if (empty($longitude)) {
            throw new \InvalidArgumentException('longitude cannot be empty');
        }

        if (!is_string($address)) {
            throw new \InvalidArgumentException('Store address cannot be empty');
        }
    
        if (empty($address)) {
            throw new \InvalidArgumentException('Address cannot be empty');
        }

        if (!is_string($zipCode)) {
            throw new \InvalidArgumentException('Store zipCode cannot be empty');
        }
    
        if (empty($zipCode)) {
            throw new \InvalidArgumentException('Zip code cannot be empty');
        }

        if (!is_string($zipCode)) {
            throw new \InvalidArgumentException('Store zipCode cannot be empty');
        }

        if (!is_string($city)) {
            throw new \InvalidArgumentException('Store zipCode cannot be empty');
        }
    
        if (empty($city)) {
            throw new \InvalidArgumentException('City cannot be empty');
        }
    
        if (!$manager instanceof Manager) {
            throw new \InvalidArgumentException('Manager should be an instance of Manager entity');
        }

        return true;
    }
}
