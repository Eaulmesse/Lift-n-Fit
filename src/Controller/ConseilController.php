<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Conseil;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Repository\ConseilRepository;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ConseilController extends AbstractController
{
    // #[Route('/conseil', name: 'app_conseil')]
    // public function index(): Response
    // {
    //     return $this->render('conseil/index.html.twig', [
    //         'controller_name' => 'ConseilController',
    //     ]);
    // }

    #[Route('/conseil/all', name: 'app_conseil_all')]
    public function conseilAll(ConseilRepository $conseilRepository): Response
    {
        $conseil = $conseilRepository -> findall();
        $currentUser = $this->getUser();
        
        return $this->render('conseil/conseilall.html.twig', [
            'controller_name' => 'ConseilController',
            'conseils' => $conseil,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/conseil/create', name: 'app_conseil_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {   

        
        if ($this->getUser('coach') == true) {
            
            $user = $this->getUser();
            $conseil = new Conseil();
            $date = new \DateTime();
    
            $form = $this->createFormBuilder($conseil)
            ->add('name', TextType::class)
            ->add('content', TextareaType::class,
            [
            'attr' => ['cols' => '50', 'rows' => '10'],
            ])
            ->add('imageFile', VichImageType::class,
            [
                'label' => "Image d'illustration",
                'required' => false,
            ])
            ->getForm();

            $form->handleRequest($request);
            

            if ($form->isSubmitted() && $form->isValid()) {
                $conseil->setUser($user);
                $conseil->setDate($date);
                
                $entityManager->persist($conseil);
                $entityManager->flush();          

                $conseilId = $conseil->getId();

                return $this->redirectToRoute('app_conseil_id', ['id' => $conseilId]);
            }

            
            return $this->render('conseil/create.html.twig', [
                'ConseilForm' => $form->createView(),
            ]);

        } else {
            return $this->redirectToRoute('app_login');
        }
    }


    #[Route('/conseil/{id}', name: 'app_conseil_id')]
    public function post(string $id, ConseilRepository $conseilRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $conseil = $conseilRepository -> find($id);
        $conseilId = $conseil->getId();
        

        


        return $this->render('conseil/conseil.html.twig', [
            'controller_name' => 'PostController',
            'conseil' => $conseil,
        ]);
    }
}
