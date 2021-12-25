<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{

    /**
     * @Route("/searchbar", name="searchbar") 
     */
    public function searchBar(WorkRepository $workRepository): Response
    {
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class)
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        return $this->render('search/search.html.twig', [
            'form' => $form->createView(),
            'works' => $workRepository->findAll(),
        ]);
    }


    /**
     * @Route("/handleSearch", name="handleSearch") 
     */
    public function handleSearch(Request $request, WorkRepository $workRepository): Response
    {
        $query = $request->request->get('form')['query'];
        return $this->render('search/searchResult.html.twig', [
            'works' => $workRepository->findBy(['title' => $query]),
        ]);
    }
}
