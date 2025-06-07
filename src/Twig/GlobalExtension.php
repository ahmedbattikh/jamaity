<?php

namespace App\Twig;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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