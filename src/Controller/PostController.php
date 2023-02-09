<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/post/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $user = $this->getUser();
        $user->getId();
        $post = new Post();

        $form = $this->createFormBuilder()
        ->add('user_id', HiddenType::class, [
            'data' => $user,
        ])
        ->add('name', TextType::class)
        ->add('content', TextType::class)
        ->getForm();



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // return $this->redirectToRoute('app_post');
            $entityManager->persist($post);
            $entityManager->flush();
        }

        
        return $this->render('post/create.html.twig', [
            'PostForm' => $form->createView(),
        ]);
        
    }
    
}
