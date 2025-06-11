<?php

namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MediaUploadController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('/admin/media/upload', name: 'admin_media_upload', methods: ['POST'])]
    public function upload(Request $request): JsonResponse
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('upload');
        
        if (!$uploadedFile) {
            return new JsonResponse([
                'error' => [
                    'message' => 'No file uploaded'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Check file type
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png', 
            'image/gif',
            'image/webp',
            'video/mp4',
            'video/avi',
            'video/mov',
            'video/wmv',
            'video/webm'
        ];

        if (!in_array($uploadedFile->getMimeType(), $allowedMimeTypes)) {
            return new JsonResponse([
                'error' => [
                    'message' => 'Only images and videos are allowed'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Create MediaObject entity
        $mediaObject = new MediaObject();
        $mediaObject->setFile($uploadedFile);

        // Validate the entity
        $errors = $this->validator->validate($mediaObject);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            
            return new JsonResponse([
                'error' => [
                    'message' => implode(', ', $errorMessages)
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Save to database
        $this->entityManager->persist($mediaObject);
        $this->entityManager->flush();

        // Return success response for CKEditor
        return new JsonResponse([
            'url' => $mediaObject->getWebPath(),
            'uploaded' => 1
        ]);
    }

    #[Route('/admin/media/browse', name: 'admin_media_browse', methods: ['GET'])]
    public function browse(Request $request): Response
    {
        $type = $request->query->get('type', 'Images');
        
        // Get media objects based on type
        $queryBuilder = $this->entityManager->getRepository(MediaObject::class)
            ->createQueryBuilder('m')
            ->where('m.fileName IS NOT NULL')
            ->orderBy('m.updatedAt', 'DESC');

        if ($type === 'Images') {
            $queryBuilder->andWhere('m.mimeType LIKE :imageType')
                ->setParameter('imageType', 'image/%');
        } elseif ($type === 'Videos') {
            $queryBuilder->andWhere('m.mimeType LIKE :videoType')
                ->setParameter('videoType', 'video/%');
        }

        $mediaObjects = $queryBuilder->getQuery()->getResult();

        return $this->render('admin/media_browse.html.twig', [
            'mediaObjects' => $mediaObjects,
            'type' => $type
        ]);
    }
}