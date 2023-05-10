<?php

namespace App\Controller;

use App\Entity\Collecte;
use App\Form\CollecteType;
use App\Repository\CollecteRepository;
use App\Repository\DonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collecte')]
class CollecteController extends AbstractController
{
    #[Route('/', name: 'app_collecte_index', methods: ['GET'])]
    public function index(CollecteRepository $collecteRepository , DonRepository $donRepository , Request $request ): Response
    {
        $collectes = $this->getDoctrine()->getRepository(Collecte::class)->findAll();

        return $this->render('collecte/index.html.twig', [
            'collectes' => $collectes ,
            'dons' =>$donRepository->findAll(),
        ]);
    }

    #[Route('/new/', name: 'app_collecte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollecteRepository $collecteRepository): Response
    {
        //$user = $this->getId();
        $collecte = new Collecte();
        $form = $this->createForm(CollecteType::class, $collecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collecteRepository->save($collecte, true);

            return $this->redirectToRoute('app_collecte_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('collecte/new.html.twig', [
            'collecte' => $collecte,
            'form' => $form,
           // 'user' => $user ,
        ]);
    }

    #[Route('/{id}', name: 'app_collecte_show', methods: ['GET'])]
    public function show(Collecte $collecte): Response
    {
        return $this->render('collecte/show.html.twig', [
            'collecte' => $collecte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collecte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collecte $collecte, CollecteRepository $collecteRepository): Response
    {
        $form = $this->createForm(CollecteType::class, $collecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collecteRepository->save($collecte, true);

            return $this->redirectToRoute('app_collecte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collecte/edit.html.twig', [
            'collecte' => $collecte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collecte_delete', methods: ['POST'])]
    public function delete(Request $request, Collecte $collecte, CollecteRepository $collecteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collecte->getId(), $request->request->get('_token'))) {
            $collecteRepository->remove($collecte, true);
        }

        return $this->redirectToRoute('app_collecte_index', [], Response::HTTP_SEE_OTHER);
    }
}
