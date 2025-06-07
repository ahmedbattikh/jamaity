<?php

namespace App\Repository;

use App\Entity\Expert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expert>
 *
 * @method Expert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expert[]    findAll()
 * @method Expert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expert::class);
    }

    /**
     * Find experts by organization
     */
    public function findByOrganization($organization): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.workedWith', 'o')
            ->andWhere('o = :organization')
            ->setParameter('organization', $organization)
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts by training
     */
    public function findByTraining(string $training): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('JSON_CONTAINS(e.training, :training) = 1')
            ->setParameter('training', json_encode($training))
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Search experts by name or description
     */
    public function searchExperts(string $query): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.firstName LIKE :query OR e.lastName LIKE :query OR e.description LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts by gender
     */
    public function findByGender(string $gender): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.gender = :gender')
            ->setParameter('gender', $gender)
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts by area of expertise
     */
    public function findByAreaOfExpertise(string $areaOfExpertise): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.areaOfExpertise LIKE :areaOfExpertise')
            ->setParameter('areaOfExpertise', '%' . $areaOfExpertise . '%')
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts by region
     */
    public function findByRegion(string $region): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.region LIKE :region')
            ->setParameter('region', '%' . $region . '%')
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Enhanced search including new fields
     */
    public function searchExpertsEnhanced(string $query): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.firstName LIKE :query OR e.lastName LIKE :query OR e.description LIKE :query OR e.areaOfExpertise LIKE :query OR e.region LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('e.lastName', 'ASC')
            ->addOrderBy('e.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}