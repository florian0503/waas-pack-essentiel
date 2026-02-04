<?php

namespace App\Controller\Admin;

use App\Entity\Realisation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre'),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads/realisations')
                ->setUploadDir('public/uploads/realisations')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true),
            BooleanField::new('actif', 'Actif'),
        ];
    }
}
