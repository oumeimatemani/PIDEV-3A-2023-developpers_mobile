<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\CategoriePType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CategorieP;
use App\Form\ProduitType ;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategoriePController extends AbstractController
{
    #[Route('/categoriep', name: 'display_categorie')]
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $categorie = $em->findAll(); // Select * from categorie;
        return $this->render('categorie_P/index.html.twig', ['listC'=>$categorie]);
    }
    #[Route('/ajouterCategorie', name: 'ajouterCategorie')]
    public function ajouterCategorie(Request $request): Response
    {

        $categorie = new CategorieP(); // init objet
        $form = $this->createForm(CategoriePType::class,$categorie);

        $form->handleRequest($request); // bch man5srhomich ya3ni les donnees yab9o persisté



        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
            $em->persist($categorie);//ajout
            $em->flush();// commit

            return $this->redirectToRoute('ajouterCategorie');

        }

        return $this->render('categorie_P/createcategorie.html.twig',
            ['f'=>$form->createView()]
        );
    }

    #[Route('/modifierCategorie/{id}', name: 'modifierCategorie')]
    public function modifierCategorie(Request $request,$id): Response
    {
        $categorie= $this->getDoctrine()->getManager()->getRepository(CategorieP::class)->find($id);

        $form = $this->createForm(CategoriePType::class,$categorie);

        $form->handleRequest($request); // bch man5srhomich ya3ni les donnees yab9o persisté



        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
            $em->persist($categorie);//ajout
            $em->flush();// commit

            return $this->redirectToRoute('display_categorie');

        }

        return $this->render('categorie_P/modifiercategorie.html.twig',
            ['f'=>$form->createView()]
        );
    }
    #[Route('/supprimerCategorie/{id}', name: 'supprimeCategorie')]
    public function suppressionCategorie(CategorieP  $categorie): Response
    {

        $em = $this->getDoctrine()->getManager();// ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $em->remove($categorie);
        //MISE A JOURS
        $em->flush();

        return $this->redirectToRoute('display_categorie');
    }

    /**
     * @Route("/categoriePP/{id}", name="produits_par_categorie")
     */
    public function produitsParCategorie(CategorieP $idcatP)
    {
        $categories = $this->getDoctrine()
            ->getRepository(CategorieP::class)
            ->findAll();
        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findBy(['idcatP' => $idcatP]);

        return $this->render('categorie_P/ShowProductsByCat.html.twig', [
            'idcatP' => $idcatP,
            'produits' => $produits,
            'cat'=> $categories
        ]);
    }






    #[Route('/categorieAPI', name: 'display_categorie')]
    public function allCatApi(Request $request,NormalizerInterface $normalizer): Response
    {

        $em = $this->getDoctrine()->getManager()->getRepository(CategorieP::class); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $categorie = $em->findAll(); // Select * from categorie;
        $jsonContent =$normalizer->normalize($categorie, 'json' ,['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/addCategorieAPI", name="addcategoriejson")
     */
    public function addproduitjson(NormalizerInterface $Normalizer,Request $request,EntityManagerInterface $entityManager): Response
    {
        $cat = new CategorieP();
        $em = $this->getDoctrine()->getManager();
        $cat->setNomC($request->get('nom_categorie'));
        $cat->setDescriptionCat($request->get('desc_categorie'));
        $cat->setDateCreation(new \DateTime($request->get('date')));
        $em->persist($cat);
        $em->flush();
        $jsonContent = $Normalizer->normalize($cat, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/editCatAPI/{id}", name="editCatJson")
     */
    public function editCatAPI ($id,Request $request, EntityManagerInterface $entityManager , NormalizerInterface $normalizer ): Response
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(CategorieP::class)->find($id);
        $cat->setNomC($request->get('nom_categorie'));
        $cat->setDescriptionCat($request->get('desc_categorie'));
        $cat->setDateCreation(new \DateTime($request->get('date')));
        $entityManager->persist($cat);
        $entityManager->flush();
        $jsonContent =$normalizer->normalize($cat, 'json' ,['groups'=>'post:read']);
        return new Response("information updated successfully". json_encode($jsonContent));

    }
    /**
     * @Route("/deleteCatApi/{id}", name="delete_cat_json")
     */
    public function deleteCatApi(Request $request,NormalizerInterface $normalizer,$id): Response
    {

        $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $cat = $this->getDoctrine()->getManager()->getRepository(CategorieP::class)->find($id); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $em->remove($cat);
        $em->flush();
        $jsonContent =$normalizer->normalize($cat, 'json' ,['groups'=>'post:read']);
        return new Response("information deleted successfully".json_encode($jsonContent));
    }



}
