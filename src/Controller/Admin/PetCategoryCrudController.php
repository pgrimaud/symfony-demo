<?php

namespace App\Controller\Admin;

use App\Entity\PetCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PetCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PetCategory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('name'),
            ImageField::new('picture')
                ->setUploadDir('public/uploads/pet-categories')
                ->setBasePath('uploads/pet-categories')
        ];
    }

}
