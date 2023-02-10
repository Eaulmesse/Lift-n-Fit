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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Repository\PostRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PostController extends AbstractController
{

    #[Route('/post/all', name: 'app_post_all')]
    public function postAll(string $id, PostRepository $postRepository): Response
    {
        $post = $postRepository -> findall();
        
        return $this->render('post/postall.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
        ]);
    }
    
    #[Route('/post/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $post = new Post();
        $date = new \DateTime();
  
        $form = $this->createFormBuilder($post)
        ->add('name', TextType::class)
        ->add('content', TextareaType::class,
        [
        'attr' => ['cols' => '50', 'rows' => '10'],
        ])
        ->getForm();

        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($user);
            $post->setDate($date);

            
            $entityManager->persist($post);
            $entityManager->flush();          

            $postid = $post->getId();

            return $this->redirectToRoute('app_post_id', ['id' => $postid]);
        }

        
        return $this->render('post/create.html.twig', [
            'PostForm' => $form->createView(),
        ]);
        
    }

    #[Route('/post/{id}', name: 'app_post_id')]
    public function post(string $id, PostRepository $postRepository): Response
    {
        $post = $postRepository -> find($id);

        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
        ]);
    }

    
    
}
