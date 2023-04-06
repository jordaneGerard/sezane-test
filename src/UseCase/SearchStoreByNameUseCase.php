<?php

namespace App\UseCase;

use App\Exception\StoreNotFoundException;
use App\Repository\StoreRepository;
use Knp\Component\Pager\PaginatorInterface;

class SearchStoreByNameUseCase
{
    private $storeRepository;
    private $paginator;

    public function __construct(StoreRepository $storeRepository, PaginatorInterface $paginator)
    {
        $this->storeRepository = $storeRepository;
        $this->paginator = $paginator;
    }

    public function execute(string $name, int $page = 1, int $limit = 3)
    {
        // On récupère les magasins correspondants au nom
        $storesQuery = $this->storeRepository->searchByNameQueryBuilder($name);

        if(empty($storesQuery->getQuery()->getResult()))
        {
            return throw new StoreNotFoundException('Stores not found');
        }

        // On construit la requête de pagination
        $pagination = $this->paginator->paginate(
            $storesQuery,
            $page,
            $limit
        );

        return $pagination;
    }
}