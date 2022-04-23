<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte", name="app_account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/compte/modifier_mot_passe",name="app_edit_password")
     */
    public function edit_password(EntityManagerInterface $em, Request  $request,UserPasswordEncoderInterface  $userPasswordEncoder):Response
    {
        $form = $this->createForm(ChangePasswordType::class,null,['current_password_is_required'=>true]);
        $user = $this->getUser();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                ($userPasswordEncoder->encodePassword($user,$form['newPassword']->getData()))
            );
            $em->flush();

            return $this->redirectToRoute('app_account');
        }
        else{
            $notification = "votre mot de passe actuelle n'est pas le bon";
        }

        return $this->render('account/password.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
