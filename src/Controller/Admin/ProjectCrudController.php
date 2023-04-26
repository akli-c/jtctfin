<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public const PROJECTS_BASE_PATH = 'img/projects';
    public const PROJECTS_UPLOAD_DIR ='public/img/projects';
    public const SLIDERS_BASE_PATH = 'img/projects/sliders';
    public const SLIDERS_UPLOAD_DIR ='public/img/projects/sliders';
    
    public function configureActions(Actions $actions): Actions
{
    return $actions
        // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('name'),
            TextareaField::new('invite'),
            TextAreaField::new('description'),
            TextareaField::new('mot'),
            TextField::new('ticket'),
            MoneyField::new('Price')
            ->setStoredAsCents(false)
            ->setCurrency('EUR'),
            ImageField::new('logo')
            ->setBasePath(self::PROJECTS_BASE_PATH)
            ->setUploadDir(self::PROJECTS_UPLOAD_DIR),
            // ImageField::new('images')
            // ->setBasePath(self::PROJECTS_BASE_PATH)
            // ->setUploadDir(self::PROJECTS_UPLOAD_DIR)
            // ->setFormTypeOption('multiple', true),
            NumberField::new('progress'),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
            BooleanField::new('active')
        ];
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Project) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void 
    {
        if (!$entityInstance instanceof Project) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::updateEntity($entityManager, $entityInstance);
    }
 
}
