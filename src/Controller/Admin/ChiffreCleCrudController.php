<?php

namespace App\Controller\Admin;

use App\Entity\ChiffreCle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/** @extends AbstractCrudController<ChiffreCle> */
class ChiffreCleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChiffreCle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Chiffre clé')
            ->setEntityLabelInPlural('Chiffres clés')
            ->setDefaultSort(['position' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('nombre', 'Nombre'),
            TextField::new('label', 'Label'),
            TextField::new('icone', 'Icône (classe Font Awesome)')->setHelp('Ex: fa fa-users, fa fa-briefcase'),
            IntegerField::new('position', 'Position'),
            BooleanField::new('actif', 'Actif'),
        ];
    }
}
