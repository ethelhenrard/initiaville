<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
     // il faut etre loggé pour pouvoir rajouter un projet

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form['pictureFile']->getData();

            if ($pictureFile) {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $project->setPicture($pictureFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $project->setUser($this->getUser()); // recupere le user qui a submit le nouveau projet (comme dans les fixtures)
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', "Bravo! Vous avez proposé un nouveau projet!");

            return $this->redirectToRoute('user_show', ["id" => $this->getUser()->getId()]);
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Project $project, FileUploader $fileUploader): Response
    {
        //verifier si l'utilisateur connecté est admin ou si c'est bien lui qui a créé le projet
        if (!$this->isGranted("ROLE_ADMIN") && $this->getUser() !== $project->getUser()) {
            //throw $this->createAccessDeniedException("Vous n'avez pas l'autorisation de modifier ce projet");
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form['pictureFile']->getData();

            if ($pictureFile) {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $project->setPicture($pictureFilename);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', ["id" => $this->getUser()->getId()]);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Project $project): Response
    {
        //verifier si l'utilisateur connecté est admin ou si c'est bien lui qui a créé le projet
        if (!$this->isGranted("ROLE_ADMIN") && $this->getUser() !== $project->getUser()) {
            //throw $this->createAccessDeniedException("Vous n'avez pas l'autorisation de modifier ce projet");
            return $this->redirectToRoute('homepage');
        }

        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_show', ["id" => $this->getUser()->getId()]);
    }
}
