<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine();

        $projects = $entityManager->getRepository(Project::class)->findAll();


        return $this->render('default/index.html.twig', [
            'projects' => $projects,

        ]);
    }

        public function searchFor(CategoryRepository $categoryRepository)
        {
        return $this->render("default/_search.html.twig", [
            "categories" => $categoryRepository->findAll()
        ]);

        }

}
