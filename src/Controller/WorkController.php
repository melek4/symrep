<?php

namespace App\Controller;

use App\Entity\Work;
use App\Entity\WorkLike;
use App\Form\WorkType;
use App\Repository\WorkRepository;
use App\Repository\CategoryRepository;
use App\Repository\WorkLikeRepository;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/work")
 */
class WorkController extends AbstractController
{
    /**
     * @Route("/bycateg", name="work_bycateg_index", methods={"GET"})
     */
    public function index(WorkRepository $workRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('work/index.html.twig', [
            'works' => $workRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="work_index", methods={"GET"})
     */
    public function works(WorkRepository $workRepository): Response
    {
        return $this->render('work/works.html.twig', [
            'works' => $workRepository->findAll(),
        ]);
    }

    /**
     * @Route("/editor/new", name="work_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $work = new Work();
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('work')['filename'];

            $uploads_directory = $this->getParameter('uploads_directory');

            $file_name = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $uploads_directory,
                $file_name
            );

            $work->setFilename($file_name);



            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('work_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('work/new.html.twig', [
            'work' => $work,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="work_show", methods={"GET"})
     */
    public function show(Work $work): Response
    {
        return $this->render('work/show.html.twig', [
            'work' => $work,
        ]);
    }

    /**
     * @Route("/editor/{id}/edit", name="work_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Work $work, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('work_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('work/edit.html.twig', [
            'work' => $work,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/editor/{id}", name="work_delete", methods={"POST"})
     */
    public function delete(Request $request, Work $work, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $work->getId(), $request->request->get('_token'))) {
            $entityManager->remove($work);
            $entityManager->flush();
        }

        return $this->redirectToRoute('work_index', [], Response::HTTP_SEE_OTHER);
    }


    /** 
     * @Route("/{id}/like", name="work_like", methods={"GET", "POST"})
     * 
     * @param \App\Entity\Work $work
     * @param \App\Repository\WorkLikeRepository $likeRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function like(Work $work, EntityManagerInterface $manager, WorkLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();

        if (!$user) {
            echo '<script>alert("You must be logged in to perform this action!")</script>';
        } //return $this->json([
        //'code' => 403,
        //'message' => "Unauthorized"
        //], 403);

        if ($work->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'work' => $work,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();


            return $this->redirectToRoute('work_index', [], Response::HTTP_SEE_OTHER);

            //return $this->json([
            //    'code' => 200,
            //    'message' => "Unliked",
            //    'likes' => $likeRepo->count(['work' => $work])
            //], 200);
        }

        $like = new WorkLike();
        $like->setWork($work)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();
        return $this->redirectToRoute('work_index', [], Response::HTTP_SEE_OTHER);
    }


    /** 
     * @Route("/{id}/like2", name="work_like2", methods={"GET", "POST"})
     * 
     * @param \App\Entity\Work $work
     * @param \App\Repository\WorkLikeRepository $likeRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function like2(Work $work, EntityManagerInterface $manager, WorkLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();

        if (!$user) {
            echo '<script>alert("You must be logged in to perform this action!")</script>';
        } //return $this->json([
        //'code' => 403,
        //'message' => "Unauthorized"
        //], 403);

        if ($work->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'work' => $work,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->redirectToRoute('work_bycateg_index', [], Response::HTTP_SEE_OTHER);

            //return $this->json([
            //    'code' => 200,
            //    'message' => "Unliked",
            //    'likes' => $likeRepo->count(['work' => $work])
            //], 200);
        }

        $like = new WorkLike();
        $like->setWork($work)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();
        return $this->redirectToRoute('work_bycateg_index', [], Response::HTTP_SEE_OTHER);
    }
}
