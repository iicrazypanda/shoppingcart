<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class CartController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cartItems = [];
        $getcart = $session->get('cart');
        foreach($getcart as $key => $value){
            array_push($cartItems,["product" => $productRepository->find($key), "aantal" => $value]);
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cartItems,
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/{id}/del", name="delCart")
     */
    public function delCart($id){
        $getCart = $this->session->get('cart');
        unset($getCart[$id]);
        return $this->redirectToRoute("cart");
    }
}
