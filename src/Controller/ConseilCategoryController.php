<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConseilCategoryController extends AbstractController
{
    #[Route('/conseil/category', name: 'app_conseil_category')]
    public function index(): Response
    {
        return $this->render('conseil_category/index.html.twig', [
            'controller_name' => 'ConseilCategoryController',
        ]);
    }
}
