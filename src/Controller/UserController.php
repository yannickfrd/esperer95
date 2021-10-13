<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/user', name: 'user')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response
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
            'form' => $form->createView(),
            'users' => $userRepository->getAllUserByLastname()
        ]);
    }

    #[Route('/delete-user/{id}', name: 'delete_user', methods: ["DELETE"])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager,): JsonResponse
    {
        if (!$user) {
            $this->addFlash('danger', 'L\'utilisateur choisi n\'existe pas');
            return $this->json([], 404);
        }

        try {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur choisi a bien été supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e);
            return $this->json([], 404);
        }

        // Redirection referer page
        return $this->json([
            'redirection' => $this->redirect($request->headers->get('referer'))
        ]);
    }
}
