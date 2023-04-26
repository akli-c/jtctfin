<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\ContactType;
use App\Services\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MailController extends AbstractController
{
    // #[Route('/mail', name: 'app_mail')]
    // public function index(): Response
    // {   
    //     return $this->render('mail/index.html.twig');
    // }

//     #[Route('/mail', name: 'contact')]
//     public function contact (
//         Request $request,
//         MailerService $mailerService
//     ): Response
//     {
//         $formContact = $this->createForm(ContactType::class, null);
//         $formContact->handleRequest($request);

//         if ($formContact->isSubmitted() && $formContact->isValid()) {
//             $data = $formContact->getData();
//             $mailerService->send(
//                 "New message",
//                 "aklichitti@gmail.com",
//                 "aklichitti67@gmail.com",
//                 "mail/mail.html.twig", 
//                 [
//                     "name" => $data['name'],
//                     'email' => $data['email'],
//                     "message" => $data['description'],
//                 ]
//                 );
//         }

//         return  $this->render('mail/index.html.twig', [
//             'formContact' => $formContact->createView()
//         ]);

// }

#[Route('/invite', name: 'invite')]
public function sendInviteEmail(Request $request, ManagerRegistry $doctrine,string $inviteId, MailerService $mailerService)
{
    // Retrieve the invite information from the database
    $invite = $doctrine->getManager()
        ->getRepository(Mail::class)
        ->findOneBy(['id' => $inviteId]);

    // Build the email
    $formContact = $this->createForm(ContactType::class, null);
    $formContact->handleRequest($request);
    
    if ($formContact->isSubmitted() && $formContact->isValid()) {
        $data = $formContact->getData();
        $mailerService->send(
            "New message",
            "aklichitti@gmail.com",
            "aklichitti67@gmail.com",
            "mail/mail.html.twig", 
            [
                "name" => $data['name'],
                'email' => $invite->getEmail(),
                "message" => ("You have been invited to support the following project: {$invite->getProject()->getName()}. Follow this link to learn more and support: http://example.com/projects/{$invite->getProject()->getId()}/{$inviteId}"),
            ]
            );
    }
    return  $this->render('mail/index.html.twig', [
        'formContact' => $formContact->createView()
    ]);
}
}
