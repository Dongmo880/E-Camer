<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    /**
     * @Route("/compte/adress", name="app_account_address")
     */
    public function index(): Response
    {
        return $this->render('account_adress/index.html.twig');
    }

    /**
     * @Route("/compte/adress/add", name="app_account_adress_add")
     */
    public function add(Request  $request,EntityManagerInterface  $em): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressFormType::class,$address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $address->setUser($this->getUser());
            $address = $form->getData();
            $em->persist($address);
            $em->flush();
            return  $this->redirectToRoute('app_account_address');
        }
        return $this->render('account_adress/form.html.twig',[
            'adresses'=>$address,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/adress/edit/{id}", name="app_account_adress_edit")
     */
    public function edit(Request  $request,EntityManagerInterface  $em,$id): Response
    {
        $address = $em->getRepository(Address::class)->findOneById($id);
        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account_address');
        }
        $form = $this->createForm(AddressFormType::class,$address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return  $this->redirectToRoute('app_account_address');
        }
        return $this->render('account_adress/form.html.twig',[
            'adresse'=>$address,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/adress/delete/{id}", name="app_account_adress_delete")
     */
    public function delete(EntityManagerInterface $em,$id): Response
    {
        $address = $em->getRepository(Address::class)->findOneById($id);
        if(!$address && $address->getUser() == $this->getUser()){
            $em->remove($address);
            $em->flush();
        }

        return  $this->redirectToRoute('app_account_address');
    }

}
