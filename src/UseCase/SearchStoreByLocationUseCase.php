<?php 

namespace App\UseCase;

use App\Repository\StoreRepository;

class SearchStoreByLocationUseCase
{
    public function __construct(private readOnly StoreRepository $storeRepository)
    {
        
    }

    public function execute()
    {
        
    }
}