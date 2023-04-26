<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserPageController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id}', name: 'app_user_page')]
    public function index(ManagerRegistry $doctrine, int $id) : Response
    {
        //$user = $this->getUser();
        //assert($user instanceof User);
        
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $projects = $em->getRepository(Project::class)->findAll();
        //dd($user);
        return $this->render('user_page/index.html.twig', [
            'user' => $user,
            'projects' => $projects
        ]);  
    }
}
