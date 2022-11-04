<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'team')]
    public function index(): Response
    {
        return $this->render('pages/team.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
}
