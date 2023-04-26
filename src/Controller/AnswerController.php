<?php

namespace App\Controller;

use App\Entity\Qna;
use DateTimeImmutable;
use App\Repository\QnaRepository;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Answer;

class AnswerController extends AbstractController
{
    #[Route('/ajax/ans', name: 'app_ans_add')]
    public function add(Request $request, QnaRepository $qnaRepo, EntityManagerInterface $em):Response
    {
        $ansData = $request->request->all('ans');
        if (!$this->isCsrfTokenValid('ans-add', $ansData['_token'])) {
            return $this->json([
                'code' => 'invalid_csrf_token'
            ], Response::HTTP_BAD_REQUEST);
        }

        $qna = $qnaRepo->findOneBy(['id'=>$ansData['qna']]);

        if (!$qna) {
            return $this->json([
                'code' => 'question_not_found'
            ], Response::HTTP_BAD_REQUEST);
        }

        $ans = new Answer($qna);
        $ans->setContent($ansData['content']);
        $ans->setUser($this->getUser());
        $ans->setCreatedAt(new DateTimeImmutable());

        $em->persist($ans);
        $em->flush();

        $html = $this->renderView('answer/index.html.twig', [
            'ans' => $ans
        ]);

        return $this->json([
            'code' => 'answer_added_succesfully',
            'message' =>$html
        ]);
    }
}
