<?php

namespace App\Repository;

use App\Entity\ProductStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductStore>
 *
 * @method ProductStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductStore[]    findAll()
 * @method ProductStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductStoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductStore::class);
    }

    public function save(ProductStore $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductStore $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllProductWithStoreQuantities()
    {
        $result = $this->createQueryBuilder('ps')
            ->select('p.id', 'p.name', 's.id as store_id', 's.name as store_name', 'ps.quantity')
            ->join('ps.product', 'p')
            ->join('ps.store', 's')
            ->orderBy('p.name', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();

        $data = [];
        
        foreach ($result as $row) {
            $productId = $row['id'];
            $store = [
                'id' => $row['store_id'],
                'name' => $row['store_name'],
                'quantity' => $row['quantity']
            ];
    
            if (!isset($data[$productId])) {
                $data[$productId] = [
                    'id' => $productId,
                    'name' => $row['name'],
                    'stores' => []
                ];
            }
    
            $data[$productId]['stores'][] = $store;
        }
    
        return array_values($data);
    }
}
