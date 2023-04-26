<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin', methods:["GET"])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $usersRepo): Response
    {
            return $this->render('admin/index.html.twig', [
                'users' => $usersRepo->findByRole('ROLE_USER'),
            ]);
    }

   /*#[Route('/admin/invite/{user.id}', name: 'invite_admin', methods:["GET"])]
    #[IsGranted('ROLE_ADMIN')]
    public function invite(UserRepository $usersRepo): Response
    {
        $users = $usersRepo->findAll();  
        return $this->render('admin/index.html.twig', [
                $users ->findBy('id'),
            ]);
    }*/

    #[Route('/admin/add', name: 'add')]
    #[IsGranted('ROLE_ADMIN')]
    public function addUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            //$message=" a été ajouté avec succès";
           // $mailMessage = $user->getFirstName().' '.$user->getLastName().' '.$message;
            
           // $mailer->sendEmail(content:$mailMessage);
        
            return $this->redirect('/admin');
    }
    return $this->render('registration/register.html.twig', [
        'add' => $form->createView(),
    ]);
}

#[Route('/admin/change/{id}', name: 'change')]
    public function changeUser(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
       
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirect('/admin');
    }
    return $this->render('registration/register.html.twig', [
        'change' => $form->createView(),
    ]);
}

}
