<?php

namespace WTF\CartBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="WTF\CartBundle\Entity\CartRepository")
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;


    /**
     * Cart
     *
     * @var CartItem
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", mappedBy="cart")
     */
    protected $cartitems;

    protected $user;



    public function __construct()
    {
        $this->cartitems = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Cart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Cart
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \WTF\CartBundle\Entity\CartItem $items
     */
    public function setCartItems($cartitems)
    {
        $this->cartitems = $cartitems;
    }

    /**
     * @param \WTF\CartBundle\Entity\CartItem $items
     */
    public function addCartItem($cartitem)
    {
        $this->cartitems[] = $cartitem;
    }


    /**
     * @return \WTF\CartBundle\Entity\CartItem
     */
    public function getCartItems()
    {
        return $this->cartitems;
    }


    public function getItems()
    {
        $result = array();
        foreach ($this->cartitems as $cartitem)
        {
            $result[] = $cartitem->getItem();
        }
        return $result;
    }

    public function hasItem($item)
    {
        foreach ($this->cartitems as $cartitem)
        {
            if ($cartitem->getItem()->getId() == $item->getId())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $item
     * @return \WTF\CartBundle\Entity\CartItem
     */
    public function getCartItemByItem($item)
    {
        foreach ($this->cartitems as $cartitem)
        {
            if ($cartitem->getItem()->getId() == $item->getId())
            {
                return $cartitem;
            }
        }
        return null;

    }

    public function getTotalQuantity()
    {
        $cart_items = $this->getCartItems();
        $quantity   = 0;

        foreach ($cart_items as $cart_item)
        {
            $quantity += $cart_item->getQuantity();
        }
        return $quantity;
    }

    public function toJson()
    {
        $result = array();

        $result['totalQuantity'] = $this->getTotalQuantity();

        return json_encode($result);
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }



}
