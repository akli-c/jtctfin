<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Project;
use App\Entity\Comments;
use App\Controller\ProjectController;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\ImageCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CommentsCrudController;
use App\Entity\Founder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    //#[IsGranted('ROLE_ADMIN')]
    //#[IsGranted('is_admin' == 1)]
    //#[Security("is_granted('is_admin' == 1)")]
    #[Route('/dashboard1618', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);
        $is_admin =$user->getIsAdmin(); 
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();
        if ($is_admin == 1 ) {return $this->redirect($url);}
        else {
            throw $this->createAccessDeniedException();
        }
        
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('templates/admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('JoinTheCapTable');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'home');

        yield MenuItem::Section('Users', 'fas fa-users');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
         MenuItem::linkToCrud('Add a new user', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
         MenuItem::linkToCrud('Show users', 'fas fa-eye', User::class)
    ]);
        yield MenuItem::Section('Projects','fa-solid fa-sheet-plastic');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
         MenuItem::linkToCrud('Add a new project', 'fas fa-plus', Project::class)->setAction(Crud::PAGE_NEW),
         MenuItem::linkToCrud('Show projects', 'fas fa-eye', Project::class)
    
    ]);
    yield MenuItem::Section('News','fa-solid fa-newspaper');

    yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
     MenuItem::linkToCrud('Add a news', 'fas fa-plus', News::class)->setAction(Crud::PAGE_NEW),
     MenuItem::linkToCrud('Show News', 'fas fa-eye', News::class)
    ]);

    yield MenuItem::Section('Images','fa-solid fa-image');

    yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
        MenuItem::linkToCrud('Add an image', 'fas fa-plus', Image::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Show images', 'fas fa-eye', Image::class)
       ]);
    
    yield MenuItem::Section('Founders','fa-solid fa-person');

    yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
        MenuItem::linkToCrud('Add a founder', 'fas fa-plus', Founder::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Show founders', 'fas fa-eye', Founder::class)
       ]);
    yield MenuItem::Section('Comments','fa-solid fa-comment');
    yield MenuItem::linkToCrud('Comments', 'fas fa-comment', Comments::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
    
}
