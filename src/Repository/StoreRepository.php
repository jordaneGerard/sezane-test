<?php

namespace App\Repository;

use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Store>
 *
 * @method Store|null find($id, $lockMode = null, $lockVersion = null)
 * @method Store|null findOneBy(array $criteria, array $orderBy = null)
 * @method Store[]    findAll()
 * @method Store[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    public function save(Store $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Store $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByNameQueryBuilder(string $name): QueryBuilder
    {
        return $this->createQueryBuilder('s')
        ->where('s.name LIKE :name')
        ->setParameter('name', "%$name%")
        ->orderBy('s.name', 'ASC')
        ;
    }

    public function findByPosition(float $latitude, float $longitude, int $radiusInMeters): QueryBuilder
    {
        $earthRadius = 6371000; // mètres

        // Formule pour calculer la distance en mètres entre deux points sur la surface de la terre
        $distanceFormula = "($earthRadius * ACOS(COS(RADIANS(:latitude)) * COS(RADIANS(s.latitude)) * COS(RADIANS(s.longitude) - RADIANS(:longitude)) + SIN(RADIANS(:latitude)) * SIN(RADIANS(s.latitude))))";

        return $this->createQueryBuilder('s')
            ->select('s', $distanceFormula . ' AS distance')
            ->having('distance <= :radius')
            ->setParameter('latitude', $latitude)
            ->setParameter('longitude', $longitude)
            ->setParameter('radius', $radiusInMeters)
            ->orderBy('distance')
            ;
    }
}
