<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class MultipleFileField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_UPLOAD_DIR = 'uploadDir';
    public const OPTION_BASE_PATH = 'basePath';
    public const OPTION_UPLOADED_FILE_NAME_PATTERN = 'uploadedFileNamePattern';

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/array')
            ->setFormType(CollectionType::class)
            ->setFormTypeOptions([
                'entry_type' => FileType::class,
                'entry_options' => [
                    'attr' => ['accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt'],
                    'required' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ])
            ->setCustomOption(self::OPTION_UPLOAD_DIR, 'public/uploads/resources')
            ->setCustomOption(self::OPTION_BASE_PATH, 'uploads/resources')
            ->setCustomOption(self::OPTION_UPLOADED_FILE_NAME_PATTERN, '[randomhash].[extension]');
    }

    public function setUploadDir(string $uploadDirPath): self
    {
        $this->setCustomOption(self::OPTION_UPLOAD_DIR, $uploadDirPath);

        return $this;
    }

    public function setBasePath(string $basePath): self
    {
        $this->setCustomOption(self::OPTION_BASE_PATH, $basePath);

        return $this;
    }

    public function setUploadedFileNamePattern(string $pattern): self
    {
        $this->setCustomOption(self::OPTION_UPLOADED_FILE_NAME_PATTERN, $pattern);

        return $this;
    }
}