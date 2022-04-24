<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function index(Cart $cart,EntityManagerInterface $em): Response
    {
            return $this->render('cart/index.html.twig',[
                'cart'=>$cart->getFull()
            ]);


    }

    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add(Cart $cart,$id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/remove", name="app_cart_remove")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('app_product');
    }
    /**
     * @Route("/cart/delete/{id}", name="app_delete_produit_to_card")
     */
    public function delete(Cart $cart,$id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }
    /**
     * @Route("cart/decrease/{id}" , name="app_decrease_to_cart")
     */
    public function decrease(Cart $cart,$id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');

    }

}
