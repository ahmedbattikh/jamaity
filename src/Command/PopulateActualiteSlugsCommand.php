<?php

namespace App\Command;

use App\Entity\Actualite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:populate-actualite-slugs',
    description: 'Populate slug field for existing actualite records',
)]
class PopulateActualiteSlugsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $actualites = $this->entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.slug IS NULL OR a.slug = :empty')
            ->setParameter('empty', '')
            ->getQuery()
            ->getResult();

        $count = 0;
        foreach ($actualites as $actualite) {
            $slug = $this->generateSlug($actualite->getTitre());
            
            // Check if slug already exists and make it unique
            $originalSlug = $slug;
            $counter = 1;
            while ($this->slugExists($slug, $actualite->getId())) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $actualite->setSlug($slug);
            $count++;
        }

        $this->entityManager->flush();

        $io->success(sprintf('Successfully populated %d actualite slugs.', $count));

        return Command::SUCCESS;
    }

    private function generateSlug(string $text): string
    {
        // Convert to lowercase
        $slug = strtolower($text);
        
        // Replace accented characters
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        
        // Remove special characters and replace spaces with hyphens
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        // Remove leading/trailing hyphens
        $slug = trim($slug, '-');
        
        // Add timestamp if slug is empty
        if (empty($slug)) {
            $slug = 'article-' . time();
        }
        
        return $slug;
    }

    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $qb = $this->entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.slug = :slug')
            ->setParameter('slug', $slug);

        if ($excludeId) {
            $qb->andWhere('a.id != :id')
               ->setParameter('id', $excludeId);
        }

        return $qb->getQuery()->getOneOrNullResult() !== null;
    }
}