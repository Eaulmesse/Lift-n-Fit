<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostReponse;
use App\Entity\User;
use App\Form\PostFormType;
use App\Form\PostReponseFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Repository\PostRepository;
use App\Repository\PostReponseRepository;
use Knp\Component\Pager\PaginatorInterface;


class PostController extends AbstractController
{

    #[Route('/post/all', name: 'app_post_all')]
    public function postAll(PostRepository $postRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // $post = $postRepository -> findall();

        $pagination = $paginator->paginate(
            $postRepository->paginationQuery(),
            $request->query->get('page', 1)
        );
        
        return $this->render('post/postall.html.twig', [
            'controller_name' => 'PostController',
            'pagination' => $pagination
        ]);
    }
    
    #[Route('/post/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {   

        
        if ($this->getUser()) {
            
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

        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/post/{id}', name: 'app_post_id')]
    public function post(string $id, PostRepository $postRepository, PostReponseRepository $postReponseRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = $postRepository -> find($id);
        $reponsePost = $postReponseRepository -> findBy(array('post_id' => $post));
        $reponse = new PostReponse();
        $form = $this->createForm(PostReponseFormType::class, $reponse);
        $date = new \DateTime();
        $postid = $post->getId();
        $currentUser = $this->getUser();
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setDate($date);
            $reponse->setPostId($post);
            $reponse->setUser($currentUser);
        
            $entityManager->persist($reponse);
            $entityManager->flush();          
            
            return $this->redirectToRoute('app_post_id', ['id' => $postid]);
        }

        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
            'currentUser' => $currentUser,
            'reponsePosts' => $reponsePost,
            'PostReponseForm' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}/delete', name: 'app_post_delete')]
    public function delete(string $id, EntityManagerInterface $entityManager, Post $post): Response
    {

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute( 'app_post_all', [
            'post' => $post,
        ]);

        
    }

    
    
}
