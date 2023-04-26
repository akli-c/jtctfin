<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    #[IsGranted('ROLE_USER')]
    public function index(EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {   
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();

        //$em = $doctrine->getManager();
        //$news = $em->getRepository(News::class)->find();

        return $this->render('home_page/index.html.twig', [
            'news' => $news,
        ]);
    }
    // ...


}
