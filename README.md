WTFCartBundle

WTF ! Simple Cart Ecommerce Managment !

Simple:
- You have product/item in your project
- You want to add and delete products in a ecommerce Cart
- You want to have a simple block which displays products in a cart
- You want cart entities managment
This WTF Bundle is done for you!

### Symfony 2.3.* Compatible

### Step 1: Download WTFCartBundle using composer

Add WTFCartBundle in your composer.json:

```js
{
    "require": {
        "jordscream/cart-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update jordscream/cart-bundle
```

Composer will install the bundle to your project's `vendor/jordscream` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new WTF\CartBundle\WTFCartBundle(),
        new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
    );
}
```

Now add the config.yml the bundle configuration

``` yaml

wtf_cart:
    item_class: App\ProductBundle\Entity\Product (put your Product entity)
    user_class: WTF\UserBundle\Entity\User (put your User entity)
```

Update the database and deploy assets web

``` bash
$ php app/console doctrine:schema:update --force --complete
$ php app/console assets:install web
```

### IMPORTANT:

Define the method __toString in your entity Product


### USAGE:

To display cart summary:

``` twig
{{ render(controller("WTFCartBundle:Cart:cart")) }}
```

To add a cart add button in your product

``` twig
{% include "WTFCartBundle:Cart:button.html.twig" with {'itemId' : product.id} %}
```


-- WTF Simple --

### TODO:
- page cart detail
- clear cart button
- unit test
- PR :)
