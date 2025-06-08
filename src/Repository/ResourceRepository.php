<?php

namespace App\Repository;

use App\Entity\Resource;
use App\Entity\Organization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resource>
 *
 * @method Resource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resource[]    findAll()
 * @method Resource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resource::class);
    }

    /**
     * @return Resource[] Returns an array of Resource objects
     */
    public function findByOrganization(Organization $organization): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.organization = :organization')
            ->setParameter('organization', $organization)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Resource[] Returns an array of Resource objects grouped by organization
     */
    public function findAllGroupedByOrganization(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.organization', 'o')
            ->addSelect('o')
            ->orderBy('o.slug', 'ASC')
            ->addOrderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlug(string $slug): ?Resource
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}