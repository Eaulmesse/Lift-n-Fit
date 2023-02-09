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
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\PostRepository;

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
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $post = new Post();
  
        $form = $this->createFormBuilder($post)
        ->add('name', TextType::class)
        ->add('content', TextType::class)
        ->getForm();

        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form);
            $post->setUser($user);
            
            $entityManager->persist($post);
            $entityManager->flush();          
            return $this->redirectToRoute('app_post');
        }

        
        return $this->render('post/create.html.twig', [
            'PostForm' => $form->createView(),
        ]);
        
    }
    
}
