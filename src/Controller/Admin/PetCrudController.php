<?php

namespace App\Controller\Admin;

use App\Entity\Pet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled()->hideOnIndex(),
            TextField::new('name')->setHelp('⚠️ Name of the pet'),
            AssociationField::new('user'),
            AssociationField::new('petCategory'),
            ImageField::new('picture')
                ->setUploadDir('public/uploads/pets')
                ->setBasePath('uploads/pets')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }

}
