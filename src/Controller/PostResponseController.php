<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostResponseController extends AbstractController
{
    #[Route('/post/response', name: 'app_post_response')]
    public function index(): Response
    {
        return $this->render('post_response/index.html.twig', [
            'controller_name' => 'PostResponseController',
        ]);
    }
}
