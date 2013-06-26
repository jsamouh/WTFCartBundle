<?php
/**
 * User: Jordan Samouh | lifeextension25@gmail.com
 * Date: 26/06/13
 * Time: 11:48
 */

namespace WTF\CartBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use WTF\CartBundle\Entity\Cart;
use WTF\CartBundle\Entity\CartItem;

class CartManager
{
    protected $session    = null;
    protected $em         = null;
    protected $class_item = null;


    /**
     * @param Session $session
     * @param EntityManager $em
     * @param $classItem
     */
    public function __construct(Session $session, EntityManager $em, $classItem)
    {
        $this->session = $session;
        $this->em = $em;
        $this->class_item = $classItem;
    }

    /**
     * @return null|Cart
     */
    public function getCart()
    {
        if ($this->session->get('cart', null))
        {
            $cart = $this->getCartById($this->session->get('cart', null));
            return $cart;
        }
        return new Cart();
    }


    /**
     * @param $itemId
     * @param int $quantity
     * @return bool
     */
    public function addItem($itemId, $quantity = 1)
    {
        $cart = $this->loadCart();
        $item = $this->getItemById($itemId);

        if ($cart->hasItem($item))
        {
            $cartItem = $cart->getCartItemByItem($item);
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
            $this->em->persist($cartItem);
            $this->em->flush();
            return true;
        }

        $cartItem = new CartItem();
        $cartItem->setCart($cart);
        $cartItem->setItem($item);
        $cartItem->setQuantity($quantity);
        $cart->addCartItem($cartItem);
        $this->em->persist($cartItem);
        $this->em->persist($cart);
        $this->em->flush();
        return true;
    }

    /**
     * @param $itemId
     */
    public function removeItem($itemId)
    {
        $cart = $this->loadCart();
        $item = $this->getItemById($itemId);

        $cartItem = $cart->getCartItemByItem($item);

        if ($cartItem)
        {
            $this->em->remove($cartItem);
            $this->em->flush();
        }
    }

    /**
     * @return \WTF\CartBundle\Entity\Cart
     */
    private function loadCart()
    {
        if ($this->session->get('cart', null))
        {
            $cart = $this->getCartById($this->session->get('cart', null));
            return $cart;
        }

        $cart = new Cart();
        $this->em->persist($cart);
        $this->em->flush();
        $this->session->set('cart', $cart->getId());
        return $cart;
    }

    public function clearCart()
    {
        $cart = $this->loadCart();
        $this->em->remove($cart);
        $this->session->set('cart', null);
    }

    /**
     * @param $itemId
     * @return object
     */
    private function getItemById($itemId)
    {
        return $this->em->getRepository($this->class_item)->findOneBy(array("id" => $itemId));
    }

    /**
     * @param $cartId
     * @return Cart
     */
    private function getCartById($cartId)
    {
        return $this->em->getRepository("WTFCartBundle:Cart")->findOneBy(array("id" => $cartId));
    }

}