<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog/index", name="blog_index")
     */
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }
    /**
     * @Route("/blog/index_front", name="blog_index_front")
     */
    public function index_front(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/index_front.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }
    /**
     * @Route("/blog/new", name="blog_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BlogRepository $blogRepository): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $blog->getImageB();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){
                // ... handle exception if something happens during file upload
            }
            $em= $this->getDoctrine()->getManager();
            $blog->setImageB($fileName);
            $em->persist($blog);
            $em->flush();
            $blogRepository->save($blog, true);

            return $this->redirectToRoute('blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }
    /**
     * @Route("/blog/{id}/details", name="blog_details", methods={"GET"})
     */
    public function blog_details(Blog $blog): Response
    {
        return $this->render('blog/blog_details.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/blog/{id}/edit", name="blog_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogRepository->save($blog, true);

            return $this->redirectToRoute('blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_delete", methods={"POST"})
     */
    public function delete(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $blogRepository->remove($blog, true);
        }

        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
