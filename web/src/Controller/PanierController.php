<?php

namespace App\Controller;



use DateTime;
use App\Entity\Panier;
use App\Entity\Payment;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\CategorieP;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="display_pan")
     */
    public function index(Request $request): Response
    {
        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;
        $em = $this->getDoctrine()->getManager()->getRepository(Panier::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $error = $request->query->get('error');
        $pan = $em->findOneBy([], ['id' => 'DESC']);
        $prix = $this->PrixTotal($pan);
        return $this->render('panier/index.html.twig', [
            'Panier' => $pan,
            'TotalPrix' => $prix,
            'error' => $error,
            'listC' => $cat
        ]);
    }


    // -------------Suppression d'un produit de panier -------------------------
    /**
     * @Route("/suppressionProduitDuPanier/{idPanier}/{idProduit}", name="suppressionProduitDuPanier")
     * @ParamConverter("pan", class="App\Entity\Panier", options={"id" = "idPanier"})
     * @ParamConverter("prod", class="App\Entity\Produit", options={"id" = "idProduit"})

     */

    public function suppressionProduitDuPanier(Panier $pan, Produit  $prod): Response
    {
        $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $pan->getProduits()->removeElement($prod);
        $prod->setStock($prod->getStock() + $prod->getQuantiteproduit());
        $prod->setQuantiteproduit(0);
        $em->persist($pan);
        $em->flush();
        return $this->redirectToRoute('display_panFront');
    }

    /**
     * @Route("/CalculQuantite/{idPanier}/{idProduit}", name="CalculQuantite")
     * @ParamConverter("pan", class="App\Entity\Panier", options={"id" = "idPanier"})
     * @ParamConverter("prod", class="App\Entity\Produit", options={"id" = "idProduit"})

     */

    public function CalculQuantite(Panier $pan, Produit  $prod): int
    {
        $count = 0;
        foreach ($pan->getProduits() as $produit) {
            if ($produit->getId() === $prod->getId()) {
                $count++;
            }
        }
        return $count;
    }


    /**
     * @Route("/panierFront", name="display_panFront")
     */
    public function indexFront(Request $request): Response
    {
        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;
        $em = $this->getDoctrine()->getManager()->getRepository(Panier::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $prod = $this->getDoctrine()->getManager()->getRepository(Produit::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $error = $request->query->get('error');
        $pan = $em->findOneBy([], ['id' => 'DESC']);
        $prix = $this->PrixTotal($pan);
        return $this->render('panier/indexFront.html.twig', [
            'Panier' => $pan,
            'TotalPrix' => $prix,
            'error' => $error,
            'listC' => $cat,
            'listP' => $prod,
        ]);
    }


    /**
     * @Route("/PasserCommande", name="PasserCommande")
     */

    public function PasserCommande(Request $request): Response
    {
        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;



        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findOneBy([], ['id' => 'DESC']);
        $panier = $em->getRepository(Panier::class)->findOneBy([], ['id' => 'DESC']);

        if (count($panier->getProduits()) == 0) {
            return $this->redirectToRoute('display_prodFront', ['error' => 'votre panier est vide.']);
        }

        // If the user does not have a panier yet, create a new one
        $commande = new Commande();
        $commande->setDateCommande(new DateTime('now'));
        $commande->setPanier($panier);
        $commande->setPrixTotal($this->PrixTotal($panier));
        $commande->setStatus("En cours");
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request); // bch man5srhomich ya3ni les donnees yab9o persisté

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($commande);
            $em->flush();
            $panier = new Panier();
            $panier->setDateAjout(new DateTime());
            $em->persist($panier);
            $em->flush();

            return $this->redirectToRoute('display_commande');
        }

        return $this->render(
            'panier/passercmd.html.twig',
            [
                'Panier' => $panier,
                'f' => $form->createView(),
                'TotalPrix' => $this->PrixTotal($panier),
                'listC' => $cat
            ]

        );
    }


    public function PrixTotal(Panier $pan): float
    {
        $count = 0;
        foreach ($pan->getProduits() as $produit) {
            $count = $count + ($produit->getPrixP() * $produit->getQuantiteproduit());
        }
        return $count;
    }


    //----------------------------------------- Json -----------------------------------------------------
    // ------------------- Affichage de panier ---------------------

    /**
     * @Route("/panierJSON", name="display_pan_json")
     */
    public function panierJSON(Request $request, NormalizerInterface $normalizer): Response
    {
        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $cat = $em1->findAll(); // Select * from categorieP;
        $em = $this->getDoctrine()->getManager()->getRepository(Panier::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $pan = $em->findOneBy([], ['id' => 'DESC']);
        $prod = $this->getDoctrine()->getManager()->getRepository(Produit::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $error = $request->query->get('error');
        $prix = $this->PrixTotal($pan);

        $jsonContent = $normalizer->normalize(
            $pan->getProduits(),
            'json',
            ['groups' => 'post:read']
        );

        return new Response(json_encode($jsonContent));
    }



    // ---------------- calcul des produits dans le panier ----------------------

    /**
     * @Route("/CalculQuantiteJSON/{idPanier}/{idProduit}", name="CalculQuantiteJSON")
     * @ParamConverter("pan", class="App\Entity\Panier", options={"id" = "idPanier"})
     * @ParamConverter("prod", class="App\Entity\Produit", options={"id" = "idProduit"})
     */
    public function CalculQuantiteJSON(Panier $pan, Produit $prod, NormalizerInterface $normalizer): Response
    {
        $count = 0;
        foreach ($pan->getProduits() as $produit) {
            if ($produit->getId() === $prod->getId()) {
                $count++;
            }
        }
        $jsonContent = $normalizer->normalize(['count' => $count], 'json', ['groups' => 'post:read']);
        return new  Response("quantité=" . json_encode($jsonContent));
    }

    // ------------------- Passer une commande  -------------------------

    /**
     * @Route("/PasserCommandeAPI", name="PasserCommandeAPI")
     */

    public function PasserCommandeAPI(NormalizerInterface $normalizer, Request $request, EntityManagerInterface $entityManager): Response
    {
        $em1 = $this->getDoctrine()->getManager()->getRepository(CategorieP::class);
        $cat = $em1->findAll();
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findOneBy([], ['id' => 'DESC']);
        $panier = $em->getRepository(Panier::class)->findOneBy([], ['id' => 'DESC']);
        if (count($panier->getProduits()) == 0) {
            $responseArray = [
                'error' => 'votre panier est vide.'
            ];
            return new JsonResponse($responseArray);
        }
        $commande = new Commande();
        $commande->setDateCommande(new DateTime('now'));
        $commande->setPanier($panier);
        $commande->setPanier($panier);
        $commande->setPrixTotal($this->PrixTotal($panier));
        $commande->setStatus("En cours");
        $commande->setMailClient($request->get('mailClient'));
        $commande->setAdresseLivraison($request->get('adresseLivraison'));
        $commande->setNomClient($request->get('nomClient'));
        $em->persist($commande);
        $em->flush();
        $panier = new Panier();
        $panier->setDateAjout(new DateTime());
        $em->persist($panier);
        $em->flush();
        $responseArray = [
            'success' => 'Votre commande a été passée avec succès!'
        ];
        return new JsonResponse($responseArray);

        $commandeArray = $normalizer->normalize($commande, 'json', ['groups' => 'post:read']);
        return new JsonResponse($commandeArray);
    }

    // -------------Suppression d'un produit de panier -------------------------
    /**
     * @Route("/suppressionProduitDuPanierAPI/{id}", name="suppressionProduitDuPanierAPI")
     */
    public function suppressionProduitDuPanierAPI(Produit  $prod, NormalizerInterface $normalizer, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Panier::class);

        $queryBuilder = $repository->createQueryBuilder('p');
        $queryBuilder->orderBy('p.id', 'DESC');
        $queryBuilder->setMaxResults(1);

        $pan = $queryBuilder->getQuery()->getOneOrNullResult();
        $pan->getProduits()->removeElement($prod);
        $prod->setStock($prod->getStock() + $prod->getQuantiteproduit());
        $prod->setQuantiteproduit(0);
        $em->persist($pan);
        $em->flush();
        $responseArray = [
            'success' => 'produit retiré!'
        ];
        return new JsonResponse($responseArray);
    }

    // ---------- Calcul de prix total de la commande ------------------------

}
