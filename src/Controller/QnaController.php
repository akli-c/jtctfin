<?php

namespace App\Controller;

use DateTime;
use App\Entity\Qna;
use App\Entity\Answer;
use DateTimeImmutable;
use App\Form\Type\AnsType;
use App\Repository\QnaRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QnaController extends AbstractController
{   
    #[Route('/ajax/qnas', name: 'app_qna_add')]
    public function add(Request $request , QnaRepository $qnaRepo, EntityManagerInterface $em, ProjectRepository $projectRepo): Response
    {   
        
        $qnaData = $request->request->all('qna');
        if (!$this->isCsrfTokenValid('qna-add', $qnaData['_token'])) {
            return $this->json([
                'code' => 'invalid_csrf_token'
            ], Response::HTTP_BAD_REQUEST);
        }

        $project = $projectRepo->findOneBy(['id'=>$qnaData['project']]);

        if (!$project) {
            return $this->json([
                'code' => 'project_not_found'
            ], Response::HTTP_BAD_REQUEST);
        }

        $qna = new Qna($project);
        $qna->setContent($qnaData['content']);
        $qna->setUser($this->getUser());
        
        $qna->setCreatedAt(new DateTimeImmutable());
        $em->persist($qna);
        $em->flush();
        
        $html = $this->renderView('qna/index.html.twig', [
            'qna' => $qna
        ]);
        
        return $this->json([
            'code' => 'question_added_succesfully',
            'message' =>$html,
            'QnaCount' => $qnaRepo->count(['Project' =>$project])
        ]);
    }
}
