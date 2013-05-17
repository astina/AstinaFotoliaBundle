<?php

namespace Astina\Bundle\FotoliaBundle\Tests\Client;

use Astina\Bundle\FotoliaBundle\Client\ClientInterface;
use Astina\Bundle\FotoliaBundle\DependencyInjection\AstinaFotoliaExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testCaching()
    {
        $container = $this->createTestContainer(array(
            'api_key' => 'test',
            'use_https' => false,
            'caching' => true
        ));

        $i = 0;
        $mockClient = $this->getMock('Astina\Bundle\FotoliaBundle\Client\ClientInterface');
        $mockClient
            ->expects($this->exactly(2))
            ->method('getMediaData')
            ->will($this->returnCallback(function() use ($i) {
                return $i++;
            }));
        ;

        $container->set('astina_fotolia.client.real', $mockClient);

        $container->compile();

        /** @var ClientInterface $client */
        $client = $container->get('astina_fotolia.client');

        $this->assertInstanceOf('Astina\Bundle\FotoliaBundle\Client\CacheClient', $client);

        $client->getMediaData(1); // cache miss
        $client->getMediaData(1); // cache hit
        $client->getMediaData(2); // cache miss
        $client->getMediaData(2); // cache hit
    }

    protected function createTestContainer($config)
    {
        $container = new ContainerBuilder(new ParameterBag(array(
            'kernel.debug'       => false,
            'kernel.bundles'     => array('AstinaFotoliaBundle' => 'Astina\Bundle\FotoliaBundle\AstinaFotoliaBundle'),
            'kernel.cache_dir'   => sys_get_temp_dir(),
            'kernel.environment' => 'test',
            'kernel.root_dir'    => __DIR__.'/../../',
        )));

        $loader = new AstinaFotoliaExtension();
        $container->registerExtension($loader);
        $loader->load(array($config), $container);

        return $container;
    }
}
