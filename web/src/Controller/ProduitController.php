<?php

namespace App\Controller;

use DateTime;
use App\Entity\CategorieP;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Writer\PngWriter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="display_prod")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager()->getRepository(Produit::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $prods = $em->findAll(); // Select * from produits;
        return $this->render('produit/index.html.twig', ['listP' => $prods]);
    }

    /**
     * @Route("/ajouterProduit", name="ajouterProduit")
     */

    public function ajouterProudit(Request $request): Response
    {

        $prod = new Produit(); // init objet
        $categorie = $this->getDoctrine()->getManager()->getRepository(CategorieP::class)->findAll();

        $form = $this->createForm(ProduitType::class, $prod);

        $form->handleRequest($request); // bch man5srhomich ya3ni les donnees yab9o persisté

        if ($form->isSubmitted() && $form->isValid()) {

            $fileUpload = $form->get('imageP')->getData(); // recuperriha fikle (valeur image

            $fileName = md5(uniqid()) . '.' . $fileUpload->guessExtension(); //Cryptage image

            $fileUpload->move($this->getParameter('kernel.project_dir') . '/public/uploads', $fileName); // Creation dossier uploads

            $prod->setImageP($fileName); // colonne ta3 image bch nsob fiha esem image crypté

            //GENEREATE QR CODE

            $url = 'https://www.google.com/search?q=';

            $objDateTime = new \DateTime('NOW');
            $dateString = $objDateTime->format('d-m-Y H:i:s');

            $path = dirname(__DIR__, 2) . '/public/';


            // set qrcode
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data('https://www.youtube.com/watch?v=Vh4TnV5Xta8&ab_channel=EcoCycla')
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(400)
                ->margin(10)
                ->labelText($dateString)
                ->labelAlignment(new LabelAlignmentCenter())
                ->labelMargin(new Margin(15, 5, 5, 5))
                ->logoPath($path . 'uploads/' . $fileName)
                ->logoResizeToWidth('100')
                ->logoResizeToHeight('100')
                ->backgroundColor(new Color(255, 255, 255))
                ->build();

            //generate name
            $namePng = uniqid('', '') . '.png';

            //Save img png
            $result->saveToFile($path . 'uploads/' . $namePng);

            $result->getDataUri();

            $prod->setImageQrCode($namePng);




            $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
            $em->persist($prod); //ajout
            $em->flush(); // commit
            $this->addFlash('success', 'Le produit  a été ajouté avec succès.');
            return $this->redirectToRoute('ajouterProduit');
        }

        return $this->render(
            'produit/creationproduit.html.twig',
            ['f' => $form->createView(), 'C' => $categorie]

        );
    }

    /**
     * @Route("/suppressionProduit/{id}", name="suppressionProduit")
     */

    public function suppressionProduit(Produit  $prod): Response
    {

        $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $em->remove($prod);
        //MISE A JOURS
        $em->flush();

        return $this->redirectToRoute('display_prod');
    }

    /**
     * @Route("/modifierProduit/{id}", name="modifierProduit")
     */
    public function modifierProduit(Request $request, $id): Response
    {
        $prod = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id);

        $form = $this->createForm(ProduitType::class, $prod);

        $form->handleRequest($request); // bch man5srhomich ya3ni les donnees yab9o persisté



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
            $em->persist($prod); //ajout
            $em->flush(); // commit

            return $this->redirectToRoute('display_prod');
        }

        return $this->render(
            'produit/modifieProduit.html.twig',
            ['f' => $form->createView()]
        );
    }
    /**
     * @Route("/produitFront", name="display_prodFront")
     */
    public function indexFront(Request $request, PaginatorInterface $paginator, ProduitRepository  $ProduitRepository): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Produit::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $categories = $this->getDoctrine()
            ->getRepository(CategorieP::class)
            ->findAll();

        $query = $ProduitRepository->createQueryBuilder('p')
            ->orderBy('p.nomP', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('produit/indexFront.html.twig', ['Produit' => $pagination, 'listP' => $pagination, 'cat' => $categories]);
    }
    /**
     * @Route("/produitTrie", name="display_prod_by_Order")
     */
    public function affichageproduittrier(Request $request, ProduitRepository  $ProduitRepository, PaginatorInterface $paginator)
    {
        $categories = $this->getDoctrine()
            ->getRepository(CategorieP::class)
            ->findAll();

        $query = $ProduitRepository->createQueryBuilder('p')
            ->orderBy('p.prixP', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('produit/indexFront.html.twig', [
            'Produit' => $pagination,
            'listP' => $pagination, 'cat' => $categories
        ]);
    }
    /**
     * @Route("/produitTrieD", name="display_prod_by_Order_D")
     */
    public function affichageproduittrierDD(Request $request, ProduitRepository  $ProduitRepository, PaginatorInterface $paginator)
    {
        $categories = $this->getDoctrine()
            ->getRepository(CategorieP::class)
            ->findAll();
        $query = $ProduitRepository->createQueryBuilder('p')
            ->orderBy('p.prixP', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('produit/indexFront.html.twig', [
            'Produit' => $pagination,
            'listP' => $pagination,
            'cat' => $categories
        ]);
    }
    /**
     * @Route("/detail_produit/{id}", name="detail")
     */
    public function detailProduit(\Symfony\Component\HttpFoundation\Request $req, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->find($id);


        return $this->render('produit/detail.html.twig', array(
            'id' => $prod->getId(),
            'nomP' => $prod->getNomP(),
            'prixP' => $prod->getPrixP(),
            'descriptionP' => $prod->getDescriptionP(),

            'imageP' => $prod->getImageP(),
            'imageQrCode' => $prod->getImageQrCode(),
            'idcatP' => $prod->getIdcatP()->getNomC()
        ));
    }
    /**
     * @Route("/detail_produit_Front/{id}", name="detailFront")
     */
    public function detailProduitFront(\Symfony\Component\HttpFoundation\Request $req, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->find($id);


        return $this->render('produit/detailFront.html.twig', array(
            'id' => $prod->getId(),
            'nomP' => $prod->getNomP(),
            'prixP' => $prod->getPrixP(),
            'descriptionP' => $prod->getDescriptionP(),
            'stock' => $prod->getStock(),
            'imageP' => $prod->getImageP(),
            'imageQrCode' => $prod->getImageQrCode(),
            'idcatP' => $prod->getIdcatP()->getNomC()
        ));
    }

    // RECHERCHE
    //SEARCH

    /**
     * @Route("/ajax_search/", name="ajax_search")
     */
    public function chercherProduit(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q'); // ooofkdokfdfdf
        $products =  $em->getRepository(Produit::class)->rechercheAvance($requestString);
        if (!$products) {
            $result['products']['error'] = "Produit non trouvé :( ";
        } else {
            $result['products'] = $this->getRealEntities($products);
        }
        return new Response(json_encode($result));
    }





    // LES  attributs
    public function getRealEntities($products)
    {
        foreach ($products as $products) {
            $realEntities[$products->getId()] = [$products->getImageP(), $products->getNomP(), $products->getPrixP()];
        }
        return $realEntities;
    }


    /**
     * @Route("/exportexcel/", name="exportexcel")
     */
    public function exportProductsToExcelAction(): Response
    {

        // Récupérer la liste des produits depuis votre source de données
        $products = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        // Créer un nouveau document Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Produit');

        // Écrire les en-têtes de colonnes
        $sheet->setCellValue('A1', 'nomP');
        $sheet->setCellValue('B1', 'prixP');
        $sheet->setCellValue('C1', 'descriptionP ');
        $sheet->setCellValue('D1', 'stock ');
        $sheet->setCellValue('E1', 'idcatP ');

        // Écrire les données des produits
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->getNomP());
            $sheet->setCellValue('B' . $row, $product->getPrixP());
            $sheet->setCellValue('C' . $row, $product->getDescriptionP());
            $sheet->setCellValue('D' . $row, $product->getStock());
            $sheet->setCellValue('E' . $row, $product->getIdcatP());
            $row++;
        }

        // Créer une réponse HTTP pour le document Excel
        $response = new Response();



        // Écrire le document Excel dans la réponse HTTP
        $writer = new Xlsx($spreadsheet);
        $writer->save('listeproduit.xlsx');

        return $response;
    }

    // ------------------------------- Ajouter produit au panier ---------------------------------


    /**
     * @Route("/AjoutPanier/{id}", name="AjoutPanier")
     */

    public function AjoutPanier(Produit $prod): Response
    {

        $em = $this->getDoctrine()->getManager();

        // Fetch the panier for the current user
        $panier = $em->getRepository(Panier::class)->findOneBy([], ['id' => 'DESC']);

        if (!$panier) {
            // If the user does not have a panier yet, create a new one
            $panier = new Panier();
            $panier->setDateAjout(new DateTime());
            $em->persist($panier);
        }

        $produitInPanier = $panier->getProduits()->filter(function ($produit) use ($prod) {
            return $produit->getId() === $prod->getId();
        })->first();

        if ($produitInPanier) {
            $quantiteDansPanier = $produitInPanier->getQuantiteproduit();
            if ($quantiteDansPanier >= $produitInPanier->getStock()) {
                return $this->redirectToRoute('display_prodFront', ['error' => 'Ce produit n\'est plus disponible pour cette quantité.']);
            } else {
                $produitInPanier->setQuantiteproduit($quantiteDansPanier + 1);
                $prod->setStock($prod->getStock() - 1);
            }
        } else {
            $panier->getProduits()->add($prod);
            $prod->setQuantiteproduit(1);
            $prod->setStock($prod->getStock() - 1);
            $em->persist($prod);
        }

        // If the product quantity in the cart is reduced or removed, update the stock
        if ($produitInPanier && $produitInPanier->getQuantiteproduit() < $quantiteDansPanier) {
            $quantiteAReajouter = $quantiteDansPanier - $produitInPanier->getQuantiteproduit();
            $prod->setStock($prod->getStock() + $quantiteAReajouter);
        } elseif ($produitInPanier && $produitInPanier->getQuantiteproduit() === 0) {
            // If the product is removed from the cart, update the stock
            $prod->setStock($prod->getStock() + $quantiteDansPanier);
            $panier->getProduits()->removeElement($produitInPanier);
            $em->remove($produitInPanier);
        }

        // Persist the changes to the database
        $em->flush();

        return $this->redirectToRoute('display_prodFront');
    }






    /**
     * @Route("/produitAPI", name="display_prod_json")
     */
    public function produitAPI(\Symfony\Component\HttpFoundation\Request $request, NormalizerInterface $normalizer): Response
    {

        $em = $this->getDoctrine()->getManager()->getRepository(Produit::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $prods = $em->findAll(); // Select * from produits;
        $jsonContent = $normalizer->normalize($prods, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deleteProduitApi/{id}", name="delete_prod_json")
     */
    public function deleteProdApi(Request $request, NormalizerInterface $normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $prod = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $em->remove($prod);
        $em->flush();
        $jsonContent = $normalizer->normalize($prod, 'json', ['groups' => 'post:read']);
        return new Response("information deleted successfully" . json_encode($jsonContent));
    }
    /**
     * @Route("/editProduitAPI/{id}", name="editProdJson")
     */
    public function editProdAPI($id, Request $request, Produit $produit, EntityManagerInterface $entityManager, NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);

        $cat = $em->getRepository(CategorieP::class)->find($request->get('cat'));
        $produit->setNomP($request->get('nomP'));
        $produit->setPrixP($request->get('prixP'));
        $produit->setStock($request->get('stock'));

        $produit->setDescriptionP($request->get('descriptionP'));
        $produit->setIdcatP($cat);
        $produit->setImageP("img.png");
        $entityManager->persist($produit);
        $entityManager->flush();
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups' => 'post:read']);
        return new Response("information updated successfully" . json_encode($jsonContent));
    }
    /**
     * @Route("/addProduitAPI", name="addproduitjson")
     */
    public function addproduitjson(NormalizerInterface $Normalizer, Request $request, EntityManagerInterface $entityManager): Response
    {

        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(CategorieP::class)->find($request->get('cat'));
        $produit->setNomP($request->get('nomP'));
        $produit->setPrixP($request->get('prixP'));
        $produit->setStock($request->get('stock'));

        $produit->setDescriptionP($request->get('descriptionP'));
        $produit->setIdcatP($cat);
        $produit->setImageP("img.png");
        $em->persist($produit);
        $em->flush();
        $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }


    // ---------------------Ajouter produit au panier  : Json  ----------------

    /**
     * @Route("/AjoutPanierJson/{id}", name="AjoutPanier_json")
     */

    public function AjoutPanierJson(Produit $prod, NormalizerInterface $normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();

        // Fetch the panier for the current user
        $panier = $em->getRepository(Panier::class)->findOneBy([], ['id' => 'DESC']);

        if (!$panier) {
            // If the user does not have a panier yet, create a new one
            $panier = new Panier();
            $panier->setDateAjout(new DateTime());
            $em->persist($panier);
        }

        $produitInPanier = $panier->getProduits()->filter(function ($produit) use ($prod) {
            return $produit->getId() === $prod->getId();
        })->first();

        if ($produitInPanier) {
            $quantiteDansPanier = $produitInPanier->getQuantiteproduit();
            if ($produitInPanier->getStock() <= 0) {
                $jsonContent = $normalizer->normalize($prod, 'json', ['groups' => 'post:read']);
                return new Response("Ce produit n'est plus disponible");
            } else {
                $produitInPanier->setQuantiteproduit($quantiteDansPanier + 1);
                $prod->setStock($prod->getStock() - 1);
            }
        } else {
            $panier->getProduits()->add($prod);
            $prod->setQuantiteproduit(1);
            $prod->setStock($prod->getStock() - 1);
            $em->persist($prod);
        }

        // If the product quantity in the cart is reduced or removed, update the stock
        if ($produitInPanier && $produitInPanier->getQuantiteproduit() < $quantiteDansPanier) {
            $quantiteAReajouter = $quantiteDansPanier - $produitInPanier->getQuantiteproduit();
            $prod->setStock($prod->getStock() + $quantiteAReajouter);
        } elseif ($produitInPanier && $produitInPanier->getQuantiteproduit() === 0) {
            // If the product is removed from the cart, update the stock
            $prod->setStock($prod->getStock() + $quantiteDansPanier);
            $panier->getProduits()->removeElement($produitInPanier);
            $em->remove($produitInPanier);
        }

        // Persist the changes to the database
        $em->flush();
        $jsonContent = $normalizer->normalize($panier, 'json', ['groups' => 'post:read']);
        return new Response("produit ajouté au panier" . json_encode($jsonContent));
    }
}
