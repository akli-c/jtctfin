<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\ProjectCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Config\Security\PasswordHasherConfig;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('projects')
        ->add('active');

    }

    public const USERS_BASE_PATH = 'img/users';
    public const USERS_UPLOAD_DIR ='public/img/users';

    public function configureActions(Actions $actions): Actions
{
    
    return $actions
    //->add(Crud::PAGE_EDIT, Action::EDIT)
    ->add(Crud::PAGE_INDEX, Action::DETAIL);
    
        
}

    public function configureFields(string $pageName): iterable
    {
        

        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            EmailField::new('email'),
            ArrayField::new('roles')->hideOnForm()->hideOnIndex(),
            TextField::new('password')
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('state'),
            IntegerField::new('phone')
            ->setNumberFormat('+33%d'),
            ImageField::new('photo')
            ->setBasePath(self::USERS_BASE_PATH)
            ->setUploadDir(self::USERS_UPLOAD_DIR),
            DateTimeField::new('created_at')->hideOnIndex()->hideOnForm()->setTimezone('Europe/Amsterdam'),
            DateTimeField::new('updated_at')->hideOnIndex()->hideOnForm()->setTimezone('Europe/Amsterdam'),
            DateTimeField::new('agreedTermsAt')->hideOnIndex()->hideOnForm()->setTimezone('Europe/Amsterdam'),
            BooleanField::new('active'),
            BooleanField::new('is_admin'),
            // ...
            //ChoiceField::new('projects')->allowMultipleChoices()->setChoices;
            AssociationField::new('projects')
            ->setQueryBuilder(function(QueryBuilder $queryBuilder){
                $queryBuilder->where('entity.active = true');
            })
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->setCrudController(ProjectCrudController::class),                   
        ];}
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void 
    {
        if (!$entityInstance instanceof User) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::updateEntity($entityManager, $entityInstance);
    }

}
