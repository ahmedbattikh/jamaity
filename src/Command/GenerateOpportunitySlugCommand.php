<?php

namespace App\Command;

use App\Entity\Opportunity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:generate-opportunity-slug',
    description: 'Generate slugs for opportunities with empty slug fields',
)]
class GenerateOpportunitySlugCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Generating slugs for opportunities');

        // Find opportunities with empty or null slug
        $opportunities = $this->entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->where('o.slug IS NULL OR o.slug = :empty')
            ->setParameter('empty', '')
            ->getQuery()
            ->getResult();

        if (empty($opportunities)) {
            $io->success('All opportunities already have slugs!');
            return Command::SUCCESS;
        }

        $io->progressStart(count($opportunities));
        $updated = 0;

        foreach ($opportunities as $opportunity) {
            $slug = $this->slugger->slug($opportunity->getTitre())->lower();
            
            // Ensure uniqueness
            $baseSlug = $slug;
            $counter = 1;
            while ($this->slugExists($slug)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $opportunity->setSlug($slug);
            $updated++;
            $io->progressAdvance();
        }

        $this->entityManager->flush();
        $io->progressFinish();

        $io->success(sprintf('Successfully generated slugs for %d opportunities!', $updated));

        return Command::SUCCESS;
    }

    private function slugExists(string $slug): bool
    {
        return $this->entityManager->getRepository(Opportunity::class)
            ->findOneBy(['slug' => $slug]) !== null;
    }
}