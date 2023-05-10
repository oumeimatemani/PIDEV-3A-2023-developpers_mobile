<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route ('/resetPass/{token}',name:'app_reset_password')]
   
    public function resetPassword ( string $token, Request $request, EntityManagerInterface $manager,UserRepository $userRepository ,UserPasswordHasherInterface $passwordHacher )
    {
       //on verifie le token dans la base donnes 
       $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);
       if ($user)
       { $form=$this->createForm(ResetPasswordType::class); 
           $form->handleRequest($request); 
           if ($form->isSubmitted()&& $form->isValid()){
               //on efface le token 
               $user->setResetToken(''); 
               $user->setPassword(
                   $passwordHacher->hashPassword(
                       $user,
                       $form->get('password')->getData() 

                   )
                   );
                   $manager->persist($user); 
                   $manager->flush(); 

                   $this->addFlash('success','Mot de passe changé avec succes') ;
                   return $this->redirectToRoute('app_front'); 
                    
           }
           return $this->render('security/reset_password.html.twig',[
               'passForm'=>$form->createView()
           ]); 

       }
       $this->addFlash('danger','Token expiré') ; 
       return $this->redirectToRoute('app_login'); 
        

      
   }
 


  #[Route( '/forgot', name: 'app_forgotpass')]
  public function forgotPassword (Request $request , UserRepository $userRepository , \Swift_Mailer $mailer , TokenGeneratorInterface $tokenGenerator)
  {
     $form=$this->createForm(ForgotPasswordType::class); 
     $form->handleRequest($request); 
     if ($form->isSubmitted()&& $form->isValid())
     {
       $donnees=$form->getData(); 
       $user=$userRepository->findOneBy(['email'=>$donnees]); 
       if(!$user)//user mech maoujoud 
       {
           $this->addFlash('danger','cette adresse n\est pas valide  '); 

       }
       //token 3ibara ala autorisation lya bech nekhdem 
       //reset password mayhelha ken user autorise 
       $token=$tokenGenerator->generateToken(); 
      
       try 
       {
           $user->setResetToken($token); 
           $em=$this->getDoctrine()->getManager(); 
           $em->persist($user);
           $em->flush(); 

           
       }catch(\Exception $e){
               $this->addFlash('warning','une erreur est survenue :'.$e->getMessage());
               return $this->redirectToRoute('app_login'); 
       }
       $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
       $transport = Transport::fromDsn('smtp://ecocycla@gmail.com:pctywincdjjwjiib@smtp.gmail.com:587?verify_peer=0');
       $mailer = new Mailer($transport);
       $email= new Email();
               //bundle mailer 
       $email->from('ecocycla@gmail.com') 
       ->To($user->getEmail())
       ->html("<p>Bonjour , </p> une demande de rénitialisation de mot de passe a été effectué . Veuillez cliquer sur le lien suivant :" .$url ,'text/html' ); 

       //send mailer 
       $mailer->send($email); 
       $this->addFlash('message','Un e-mail de réinitialisation de mot de passe vous a été envoyé'); 
       return $this->render('security/forgotPassword.html.twig'
       ,['form'=> $form->createView()] ); 
       //return $this->redirectToRoute('app_login'); 




     }
     return $this->render('security/forgotPassword.html.twig', ['form' => $form->createView()]);
   }


    
}
