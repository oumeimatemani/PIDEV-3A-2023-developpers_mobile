<?php

namespace App\Controller;

use App\Entity\Don;
use App\Form\DonType;
use App\Repository\DonRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/don')]
class DonController extends AbstractController
{


    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/', name: 'app_don_index', methods: ['GET'])]
    public function index(DonRepository $donRepository ,userRepository $userRepository , Request $request , PaginatorInterface $paginator): Response
    {

       $id_role = 2;
     // $id_role =  $this->getUser()->getRoles()[3] ;

        if ($id_role === 3) {
            $dons = $donRepository->findAll();
            $user = $userRepository-> find($id_role);
        } else {
            $dons = $donRepository->findBy(['iduserdon' => $id_role]);
            $user = $userRepository-> find($id_role);
        }


        $pagination = $paginator->paginate(
            $dons,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('don/index.html.twig', [
          //  'dons' => $donRepository->findAll(),
          //  'User' => $userRepository-> find($iduser),
            'dons' => $pagination ,
            'User' => $user ,
            'action' => $id_role ,
        ]);
    }



    #[Route('/new', name: 'app_don_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DonRepository $donRepository, MailerInterface $mailer, SessionInterface $session): Response
    {
        $don = new Don();
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donRepository->save($don, true);

            $message = (new Email())
                ->from('chiheb.menjli@esprit.tn')
                ->to('chiheb.menjli@esprit.tn')
                ->subject('Nouvelle donation')
                ->text('Une nouvelle donation a été ajoutée.');

            $mailer->send($message);

            $session->getFlashBag()->add('success', 'Donation ajoutée avec succès!');

            return $this->redirectToRoute('app_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('don/new.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_don_show', methods: ['GET'])]
    public function show(Don $don): Response
    {
        return $this->render('don/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Don $don, DonRepository $donRepository ): Response
    {
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donRepository->save($don, true);

            return $this->redirectToRoute('app_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('don/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_don_delete', methods: ['POST'])]
    public function delete(Request $request, Don $don, DonRepository $donRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
            $donRepository->remove($don, true);
        }

        return $this->redirectToRoute('app_don_index', [], Response::HTTP_SEE_OTHER);
    }
}
