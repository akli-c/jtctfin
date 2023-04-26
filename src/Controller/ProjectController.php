<?php

namespace App\Controller;

use DateTime;

use DateTimeImmutable;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Comments;
use App\Form\CommentsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/project/{id}', name: 'app_project')]
    public function index(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $em = $doctrine->getManager();
        $project = $em->getRepository(Project::class)->find($id);

        //comments 
        $comment = new Comments;

        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setProject($project);
            $comment->setUser($this->getUser());


            $parentid = $commentForm->get("parentid")->getData();
            if ($parentid != null){
            $parent = $em->getRepository(Comments::class)->find($parentid);
        }
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_project', ['id' => $project->getId()]);
        }

        return $this->renderForm('project/index.html.twig', [
            'project' => $project,
            'comments' => $comment,
            'commentForm' => $commentForm
        ]);
    }
    
    
    #[IsGranted('ROLE_USER')]
    #[Route('/project/{id}/participer', name: 'app_project_participer')]
    public function participer(ManagerRegistry $doctrine, int $id, Request $request)
    {   

        $em = $doctrine->getManager();
        $project = $em->getRepository(Project::class)->find($id);
        
        $userId = $this->getUser();

        $user = $em->getRepository(User::class)->find($userId);
        
        $user->addProject($project);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_user_page', ['id' => $user->getId()]);





    }

}
