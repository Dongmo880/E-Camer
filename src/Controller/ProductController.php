<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(EntityManagerInterface $em,ProductRepository $productRepository): Response
    {
        $products = $em->getRepository(Product::class)->findAll();
        return $this->render('product/product.html.twig',[
            'products'=>$products
        ]);
    }
    /**
     * @Route("/product/{slug}", name="app_product_show")
     */
    public function show(EntityManagerInterface $em,ProductRepository $productRepository,$slug): Response
    {
        $product = $productRepository->findOneBySlug($slug);
        if(!$product){
            return $this->redirectToRoute('app_product');
        }
        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
