<?php

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation/{id}", name="invitation")
     */
    public function invitation(ManagerRegistry $doctrine,Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        // Retrieve the invitation from the database using the id
        $invitation = "...;";

        $user = $doctrine->getManager()
        ->getRepository(User::class)
        ->findOneBy(['email' => $email]);

        // Create a form to set the password
        $form = $this->createFormBuilder($user)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, ['label' => 'Set password'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the password from the form data
            $password = $form->get('password')->getData();

            // Hash the password
            $passwordHash = $passwordEncoder->encodePassword($user, $password);

            // Store the password hash in the database

            // Redirect the user to the dashboard or the desired page
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('invitation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
