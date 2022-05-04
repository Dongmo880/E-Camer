<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{
    private  $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }

    /**
     * @Route("commande/merci/{stripeSessionId}", name="app_order_validate")
     */
    public function index($stripeSessionId,Cart $cart): Response
    {
        $order = $this->em->getRepository(Order::class)->findOneByStripSessionId($stripeSessionId);
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        if(!$order->getIsPaid()){
            //vide le payer de user
            $cart->remove();
            $order->setIsPaid(1);
            $this->em->flush();
            //Envoyer un email a notre client pour lui confirmer sa commande
        }
        return $this->render('order_validate/index.html.twig', [
            'order'=>$order
        ]);
    }
}
