<?php

namespace App\EventListener;

use App\Entity\Resource;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Resource::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Resource::class)]
class FileUploadListener
{
    public function __construct(
        private SluggerInterface $slugger,
        private string $uploadsDirectory = 'public/uploads/resources'
    ) {
    }

    public function prePersist(Resource $resource, LifecycleEventArgs $event): void
    {
        $this->handleFileUploads($resource);
    }

    public function preUpdate(Resource $resource, LifecycleEventArgs $event): void
    {
        $this->handleFileUploads($resource);
    }

    private function handleFileUploads(Resource $resource): void
    {
        $files = $resource->getFiles();
        
        if (!$files) {
            return;
        }

        $uploadedFilePaths = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move($this->uploadsDirectory, $fileName);
                    $uploadedFilePaths[] = $fileName;
                } catch (\Exception $e) {
                    // Handle upload error
                    continue;
                }
            } elseif (is_string($file)) {
                // Keep existing file paths
                $uploadedFilePaths[] = $file;
            }
        }
        
        $resource->setFiles($uploadedFilePaths);
    }
}