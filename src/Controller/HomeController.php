<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PaintingRepository $paintingRepository): Response
    {
        $painting=$paintingRepository->findBy(
            [],
            ['titre' => 'ASC']
        );

        dump($painting);
        return $this->render('pages/home.html.twig',[
            'paintings' => $painting
        ]);
    }
}
