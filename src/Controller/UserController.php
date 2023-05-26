<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Knp\Component\Pager\PaginatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    #[Route('/user/account', name: 'app_user_account')]
    public function account(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();


        $formImg = $this->createFormBuilder($user)

            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'label' => "Image de profil",
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                ]
            )
            ->getForm();
        $formImg->handleRequest($request);


        if ($formImg->isSubmitted() && $formImg->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
        }



        return $this->render('user/account.html.twig', [
            'formImg' => $formImg->createView(),
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }

    #[Route('/user/account/becomecoach', name: 'app_user_becomecoach')]
    public function becomeCoach(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (null !== $user) {
            $user->setCoach(true);   
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_account');
    }

    #[Route('/coachlist', name: 'app_coach_list')]
    public function coachAll(EntityManagerInterface $entityManager, UserRepository $UserRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $pagination = $paginator->paginate(
            $UserRepository->paginationQuery(),
            $request->query->get('page', 1)
        );

        return $this->render('user/coachall.html.twig', [
            'controller_name' => 'userController',
            'pagination' => $pagination
        ]);
    }


    #[Route('/{id}/profil', name: 'app_coach_profil')]
    public function viewCoach(int $id, UserRepository $UserRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $user = $UserRepository->find($id);

        $formContent = $this->createFormBuilder($currentUser)

            ->add('content', TextareaType::class, [
                "label" => 'Modifier votre description'
            ])

            ->getForm();
        $formContent->handleRequest($request);


        if ($formContent->isSubmitted() && $formContent->isValid()) {

            $entityManager->persist($currentUser);
            $entityManager->flush();
        }
        

        return $this->render('user/coachaccount.html.twig', [
            'formContent' => $formContent->createView(),
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

        return $this->redirectToRoute('app_logout', [
            'user' => $user,
        ]);
    }
}
