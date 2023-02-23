<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CoachFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $UserRepository): Response
    {
        $users = $UserRepository -> findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    #[Route('/user/account', name: 'app_user_account')]
    public function account(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createFormBuilder($user)
            // ->add('coach',ButtonType::class)

            ->add('coach', ButtonType::class,
            [
            'attr' => ['btn', 'btn-success'],
            ])
            ->getForm();
            $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
            
        }
        
    

        return $this->render('user/account.html.twig', [
            'coachForm' => $form->createView(),
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }

    public function deleteUser(User $user, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($user);
        $entityManager->flush();
    }

    #[Route('/user/{id}/delete', name: 'app_user_delete')]
    public function delete(EntityManagerInterface $entityManager, User $user): Response
    {

        $entityManager->remove($user);
        $entityManager->flush();

        $this->deleteUser($user, $entityManager);

        return $this->redirectToRoute( 'app_logout', [
            'user' => $user,
        ]);

        
    }
}
