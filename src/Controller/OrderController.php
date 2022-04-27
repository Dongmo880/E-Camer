<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }

    /**
     * @Route("/order", name="app_order")
     */
    public function index(Cart $cart,Request $request): Response
    {
        if(!$this->getUser()->getAddresses()->getValues()){

            return  $this->redirectToRoute('app_account_adress_add');
        }
        $form = $this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);

        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }

    /**
     * @Route("recapitulatif",name="app_order_recap",methods={"POST"})
     */

    public function add(Request $request,Cart  $cart)
    {
        $form = $this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $date = new \DateTime('now');
            $carriers = $form->get('carrier')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname().''.$delivery->getLastname();
            $delivery_content .= '<br>'.$delivery->getPhone();

            if($delivery->getCompany())
            {
                $delivery_content .= '<br>'.$delivery->getCompany();
            }
            $delivery_content .= '<br>'.$delivery->getAdresse();
            $delivery_content .= '<br>'.$delivery->getPostal().''.$delivery->getCity();
            $delivery_content .= '<br>'.$delivery->getCountry();

            //Enregistrer ma commande Order
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);
            $this->em->persist($order);

            //mise en place de stripe
            foreach ($cart->getFull() as $product){
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice()*$product['quantity']);
                $this->em->persist($orderDetails);


            }
            //$this->em->flush();




            return $this->render('order/add.html.twig',[
                'cart'=>$cart->getFull(),
                'carrier'=>$carriers,
                'delivery'=>$delivery_content,
            ]);
        }
        return $this->redirectToRoute('app_cart');

    }

}
