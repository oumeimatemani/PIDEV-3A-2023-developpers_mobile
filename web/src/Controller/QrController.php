<?php

namespace App\Controller;

use App\Services\QrcodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;



class QrController extends AbstractController
{
    /**
     * @Route("/qr", name="qr")
     * @param Request $request
     * @param QrcodeService $qrcodeService
     * @return Response
     */
    public function index(Request $request, QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $form = $this->createForm(SearchType::class, data:null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);
        }

        return $this->render('qr/index.html.twig', [
            'form' => $form->createView(),
            'qrCode' => $qrCode
        ]);
    }
}