<?php

namespace App\Controller;

use App\Entity\CategorieD;
use App\Form\CategorieDType;
use App\Repository\CategorieDRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie')]
class CategorieDController extends AbstractController
{
    #[Route('/', name: 'app_categorie_d_index', methods: ['GET'])]
    public function index(CategorieDRepository $categorieDRepository): Response
    {
        return $this->render('categorie_d/index.html.twig', [
            'categorie_ds' => $categorieDRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_d_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieDRepository $categorieDRepository): Response
    {
        $categorieD = new CategorieD();
        $form = $this->createForm(CategorieDType::class, $categorieD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieDRepository->save($categorieD, true);

            return $this->redirectToRoute('app_categorie_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_d/new.html.twig', [
            'categorie_d' => $categorieD,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_d_show', methods: ['GET'])]
    public function show(CategorieD $categorieD): Response
    {
        return $this->render('categorie_d/show.html.twig', [
            'categorie_d' => $categorieD,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_d_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieD $categorieD, CategorieDRepository $categorieDRepository): Response
    {
        $form = $this->createForm(CategorieDType::class, $categorieD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieDRepository->save($categorieD, true);

            return $this->redirectToRoute('app_categorie_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_d/edit.html.twig', [
            'categorie_d' => $categorieD,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_d_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieD $categorieD, CategorieDRepository $categorieDRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieD->getId(), $request->request->get('_token'))) {
            $categorieDRepository->remove($categorieD, true);
        }

        return $this->redirectToRoute('app_categorie_d_index', [], Response::HTTP_SEE_OTHER);
    }
}
