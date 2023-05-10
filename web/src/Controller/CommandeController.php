<?php

namespace App\Controller;


use App\Entity\Commande;

use App\Entity\CategorieP;
use App\Service\PdfService;
use App\Repository\CommandeRepository;
use App\Repository\CategoriePRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class CommandeController extends AbstractController
{


    /*--------------------------------- Historique client ---------------------------------------------------*/

    /**
     * @Route("/commande", name="display_commande")
     */
    public function index(Request $request, PaginatorInterface $paginator, CommandeRepository $CommandeRepository): Response
    {

        $query = $CommandeRepository->createQueryBuilder('c')
            ->orderBy('c.dateCommande', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );


        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;

        $em = $this->getDoctrine()->getManager()->getRepository(Commande::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $commande = $em->findAll();

        $success = $request->query->get('success');

        return $this->render('panier/historiqueCmd.html.twig', [
            'Commande' => $pagination,
            'listC' => $cat,
            'success' => $success
        ]);
    }
    /*--------------------------------- Historique admin ---------------------------------------------------*/

    /**
     * @Route("/historiqueCommande", name="display_commandeAdmin")
     */
    public function indexCommande(Request $request, PaginatorInterface $paginator, CommandeRepository $CommandeRepository): Response
    {

        $query = $CommandeRepository->createQueryBuilder('c')
            ->orderBy('c.dateCommande', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;

        $em = $this->getDoctrine()->getManager()->getRepository(Commande::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $commande = $em->findAll();

        $success = $request->query->get('success');

        return $this->render('panier/historiqueAdmin.html.twig', [
            'Commande' => $pagination,
            'listC' => $cat,
            'success' => $success
        ]);
    }

    /*--------------------------------- Imprime de facture ---------------------------------------------------*/
    /**
     * @Route("/pdf/{id}", name="commande.pdf")
     */
    public function generatePdfPersonne(Commande $commande = null, PdfService $pdf)
    {
        $html = $this->render('commande/detail.html.twig', ['commande' => $commande]);
        $filename = 'commande-' . $commande->getId() . '.pdf';
        return $pdf->showPdfFile($html, $filename);
    }

    //------------------------------------- Json --------------------------------------------------------------

    /*------------- Historique client -------------------*/

    /**
     * @Route("/CommandeJSON", name="display_commande_json")
     */
    public function CommandeJSON(\Symfony\Component\HttpFoundation\Request $request, NormalizerInterface $normalizer): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Commande::class);
        $queryBuilder = $repository->createQueryBuilder('c');
        $queryBuilder->orderBy('c.id', 'DESC');
        $coms = $queryBuilder->getQuery()->getResult();
        $jsonContent = [];
        foreach ($coms as $commande) {
            $jsonContent[] = [
                'id' => $commande->getId(),
                'nomClient' => $commande->getNomClient(),
                'mailClient' => $commande->getMailClient(),
                'adresseLivraison' => $commande->getAdresseLivraison(),
                'status' => $commande->getStatus(),
            ];
        }
        return new JsonResponse($jsonContent);
    }


    /*------------ Historique admin ---------------------*/

    /**
     * @Route("/historiqueCommandeAdminJSON", name="display_commandeAdmin_json")
     */
    public function historiqueCommandeJSON(Request $request, PaginatorInterface $paginator, CommandeRepository $CommandeRepository, CategoriePRepository $categoriePRepository, NormalizerInterface $normalizer): Response
    {
        $query = $CommandeRepository->createQueryBuilder('c')
            ->orderBy('c.dateCommande', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        $cat = $categoriePRepository->findAll(); // Select * from categorieP;
        $commande = $CommandeRepository->findAll();
        $success = $request->query->get('success');

        $jsonContent = $normalizer->normalize([
            'Commande' => $pagination,
            'listC' => $cat,
            'success' => $success
        ], 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }


    /*----------- Imprime de facture ---------------------*/

    /**
     * @Route("/pdf/{id}/json", name="commande.pdf_json")
     */
    public function generatePdfPersonneAPI(Commande $commande = null, PdfService $pdf, NormalizerInterface $normalizer): Response
    {
        $html = $this->renderView('commande/detail.html.twig', ['commande' => $commande]);
        $filename = 'commande-' . $commande->getId() . '.pdf';

        $data = [
            'html' => $html,
            'filename' => $filename
        ];

        $jsonContent = $normalizer->normalize($data, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/pdfAPI/{id}", name="commande.pdf")
     */

    public function generatePdfAPI(Request $request, Commande $commande = null, PdfService $pdf, NormalizerInterface $normalizer)
    {
        $html = $this->render('commande/detail.html.twig', ['commande' => $commande]);
        $filename = 'commande-' . $commande->getId() . '.pdf';
        return $pdf->showPdfFile($html, $filename);
    }
}
