<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    private  $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }

    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="app_order_cancel")
     */
    public function index($stripeSessionId): Response
    {

        $order = $this->em->getRepository(Order::class)->findOneByStripSessionId($stripeSessionId);
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('order_cancel/index.html.twig',[
            'order'=>$order
        ]);
    }
}
