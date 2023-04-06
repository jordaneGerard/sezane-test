<?php 

namespace App\UseCase;

use App\DTO\CreateStoreRequestDTO;
use App\Entity\Store;
use App\Factory\StoreFactory;
use Doctrine\ORM\EntityManagerInterface;

class CreateStoreUseCase
{
    public function __construct(
        private readonly StoreFactory $storeFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
        
    }

    public function execute(CreateStoreRequestDTO $createStoreRequestDTO): Store
    {
        $store = $this->storeFactory->createFromDto($createStoreRequestDTO);

        $this->entityManager->persist($store);
        $this->entityManager->flush();

        return $store;
    }
}