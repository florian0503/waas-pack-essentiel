<?php

namespace App\Controller\Admin;

use App\Entity\APropos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

/** @extends AbstractCrudController<APropos> */
class AProposCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return APropos::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('À propos')
            ->setEntityLabelInPlural('À propos');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre'),
            TextareaField::new('paragraphe1', 'Paragraphe 1'),
            TextareaField::new('paragraphe2', 'Paragraphe 2')->setRequired(false),
            TextareaField::new('paragraphe3', 'Paragraphe 3')->setRequired(false),
            Field::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads/apropos')
                ->onlyOnIndex(),
        ];
    }
}
