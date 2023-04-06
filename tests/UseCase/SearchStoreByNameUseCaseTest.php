<?php

namespace App\Tests\UseCase;

use App\Exception\StoreNotFoundException;
use App\Repository\StoreRepository;
use App\UseCase\SearchStoreByNameUseCase;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class SearchStoreByNameUseCaseTest extends TestCase
{
    public function testExecuteThrowsExceptionWhenStoreNotFound()
    {
        $storeRepository = $this->createMock(StoreRepository::class);
        $queryBuilder = $this->createMock(QueryBuilder::class);
        $paginator = $this->createMock(PaginatorInterface::class);
        $name = 'Store Name';

        $storeRepository->expects($this->once())
            ->method('searchByNameQueryBuilder')
            ->with($name)
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->createMock(AbstractQuery::class));

        $this->expectException(StoreNotFoundException::class);

        $useCase = new SearchStoreByNameUseCase($storeRepository, $paginator);
        $useCase->execute($name);
    }

}
