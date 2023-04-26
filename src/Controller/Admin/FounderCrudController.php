<?php

namespace App\Controller\Admin;

use App\Entity\Founder;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FounderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Founder::class;
    }

    public const FOUNDERS_BASE_PATH = 'img/founders';
    public const FOUNDERS_UPLOAD_DIR ='public/img/founders';
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('name')->renderAsHtml(),
            TextField::new('position')->renderAsHtml(),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
            ImageField::new('photo')
            ->setBasePath(self::FOUNDERS_BASE_PATH)
            ->setUploadDir(self::FOUNDERS_UPLOAD_DIR),
            TextareaField::new('description'),
            AssociationField::new('project'),
        ];
    }
    
}
