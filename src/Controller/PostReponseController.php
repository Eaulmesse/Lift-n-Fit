<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostReponseController extends AbstractController
{
    #[Route('/post/reponse', name: 'app_post_reponse')]
    public function index(): Response
    {
        return $this->render('post_reponse/index.html.twig', [
            'controller_name' => 'PostReponseController',
        ]);
    }
}
