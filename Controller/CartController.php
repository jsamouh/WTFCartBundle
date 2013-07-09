<?php

namespace WTF\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{

    public function cartAction()
    {
        return $this->render("WTFCartBundle:Cart:index.html.twig", array('cart' => $this->getCart()));
    }


    /**
     * @Route("/add/item/{itemId}.html", name="wtf_cart_add_item")
     */
    public function addItemAction($itemId)
    {
        $this->get("wtf_cart.manager")->addItem($itemId);

        return new Response($this->getCart()->toJson());
    }

    /**
     * @Route("/delete/item/{itemId}.html", name="wtf_cart_delete_item")
     */
    public function deleteItemAction($itemId)
    {
        $this->get("wtf_cart.manager")->removeItem($itemId);

        return new Response($this->getCart()->toJson());
    }

    /**
     * @Route("/clear/cart.html", name="wtf_cart_clear")
     */
    public function clearAction()
    {
        $this->get("wtf_cart.manager")->clearCart();

        return new Response($this->getCart()->toJson());
    }

    /**
     * @Route("/cart/listItemSummary.html", name="wtf_cart_list_item_summary")
     */
    public function listItemSummaryAction()
    {
        return $this->render("WTFCartBundle:Cart:list_item_summary.html.twig", array('cart' => $this->getCart()));
    }

    /**
     * @Route("/cart/update-quantity.html/{itemId}/{quantity}", name="wtf_cart_update_quantity")
     */
    public function updateItemCartQuantityAction($itemId, $quantity = 0)
    {
        if ($quantity <= 0)
        {
            $this->get("wtf_cart.manager")->removeItem($itemId);
        }
        else
        {
            $this->get("wtf_cart.manager")->setItemQuantity($itemId, $quantity);
        }

        $cart = $this->getCart();

        return $this->render("WTFCartBundle:Cart:mycart.html.twig", array('cart' => $cart));
    }


    /**
     * @Route("/cart/mycart.html", name="wtf_cart_my_cart")
     */
    public function myCartAction()
    {
        $cart = $this->getCart();

        return $this->render("WTFCartBundle:Cart:mycart.html.twig", array('cart' => $cart));
    }


    protected function getCart()
    {
        $cart = $this->get("wtf_cart.manager")->getCart();

        return $cart;
    }
}
