<?php

namespace Astina\Bundle\FotoliaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AstinaFotoliaExtension extends Extension
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

        $clientReal = $container->getDefinition('astina_fotolia.client.real');
        $clientReal->replaceArgument(0, $config['api_key']);
        $clientReal->replaceArgument(1, $config['use_https']);
        if ($config['caching']) {
            $clientCache = $container->getDefinition('astina_fotolia.client.cache');
            $container->setDefinition('astina_fotolia.client', $clientCache);
        } else {
            $container->setDefinition('astina_fotolia.client', $clientReal);
        }
    }
}
