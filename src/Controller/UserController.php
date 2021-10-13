<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try {
                // Save on database
                $entityManager->persist($user);
                $entityManager->flush();

                // Send a status message on vue
                $this->addFlash('success', 'L\'utilisateur a bien été enregistré.');

                // Redirection
                $this->redirectToroute('user');
            }catch (\Exception $e) {
                $this->addFlash('danger', $e);
            }
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
