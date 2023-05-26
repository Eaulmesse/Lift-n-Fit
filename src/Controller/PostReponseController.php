<?php

namespace App\Controller;

use App\Entity\PostReponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
