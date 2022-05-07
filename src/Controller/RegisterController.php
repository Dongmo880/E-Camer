<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(EntityManagerInterface  $em, Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $search_email = $em->getRepository(User::class)->findOneByEmail($user->getEmail());
            if(!$search_email){
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $em->persist($user);
                $em->flush();
                //envoie email à utilisateur
                $mail = new Mail();
                $content = "Bonjour"." ".$user->getFirstname()."<br/> Bienvenue sur E-Camer à fin de commencé vos achats veuillez cliquez sur ce lien pour finaliser votre inscrption Merci";
                $mail->send($user->getEmail(),$user->getFirstname(),'E-camer Inscription',$content);

                $this->addFlash('success','Mail Inscription à été envoyé');
                return $this->redirectToRoute('app_home');
            }
            else{
                $this->addFlash('success','utilisateur existe deja');
            }
        }
        return $this->render('register/register.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
