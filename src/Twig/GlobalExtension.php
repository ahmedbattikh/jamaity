<?php

namespace App\Twig;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

class GlobalExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_latest_projects', [$this, 'getLatestProjects']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('class_name', [$this, 'getClassName']),
        ];
    }

    public function getClassName($object): string
    {
        return get_class($object);
    }

    public function getLatestProjects(int $limit = 8): array
    {
        return $this->entityManager->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->orderBy('p.dateBegin', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}