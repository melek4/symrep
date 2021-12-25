<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/userlist", name="userlist")
     */
    public function index(UserRepository $users): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/admin/edit_user/{id}", name="edit_user")
     */
    public function edituser(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('userlist');
        }
        return $this->render('user/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}
