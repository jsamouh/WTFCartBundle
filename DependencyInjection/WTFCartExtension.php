<?php

namespace WTF\CartBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WTFCartExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $classItem = $config['item_class'];
        $classUser = $config['user_class'];
        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation("WTF\CartBundle\Entity\CartItem", 'mapManyToOne', array(
            'fieldName'     => 'item',
            'targetEntity'  => $classItem,
            'cascade'       => array(
                'persist',
            ),
            'orphanRemoval' => false,
        ));


        $collector->addAssociation("WTF\CartBundle\Entity\Cart", 'mapManyToOne', array(
            'fieldName'     => 'user',
            'targetEntity'  => $classUser,
            'cascade'       => array(
                'persist',
            ),
            'orphanRemoval' => false,
        ));


        $container->setParameter("wtf_cart.item_class", $classItem);
    }
}
