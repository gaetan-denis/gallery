<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    #[Route('/detail/{slug}', name: 'detail')]
    public function index(Painting $painting, CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(
            ['painting' => $painting, 'is_published' => true],
            ['created_at' => 'DESC']
        );

        dump($comments);

        return $this->render('pages/detail.html.twig', [
            'painting'=> $painting,
            'comments' => $comments
        ]);
    }
}
