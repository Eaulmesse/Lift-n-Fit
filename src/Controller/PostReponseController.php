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

    // #[Route('/post/reponse', name: 'app_post_reponse')]
    // public function create(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->getUser()) {
            

    //         $reponse = new PostReponse();
    //         $form = $this->createForm(PostReponseFormType::class, $reponse);
    //         $date = new \DateTime();
    //         $form->handleRequest($request);
            

    //         if ($form->isSubmitted() && $form->isValid()) {
                
    //             $reponse->getPostId();
    //             $reponse->setDate($date);

    //             $entityManager->persist($reponse);
    //             $entityManager->flush();          

    //             $postid = $reponse->getPostId();

    //             return $this->redirectToRoute('app_post_id', ['id' => $postid]);
    //         }

            
    //         return $this->render('post_reponse/reponse.html.twig', [
    //             'PostReponseForm' => $form->createView(),
    //         ]);

    //     } 
    //     // else {
    //     //     return $this->redirectToRoute('app_login');
    //     // }
    // }

    
}
