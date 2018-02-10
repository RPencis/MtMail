<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMail\Factory;

use Interop\Container\ContainerInterface;
use MtMail\Renderer\RendererInterface;
use MtMail\Service\Composer;
use MtMail\Service\ComposerPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;


class ComposerServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface|ServiceLocatorInterface $serviceLocator
     * @param string $requestedName
     * @param array $options
     * @return Composer
     */
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Configuration');
        /** @var RendererInterface $renderer */
        $renderer = $container->get($configuration['mt_mail']['renderer']);
        $service = new Composer($renderer);

        $pluginManager = $container->get(ComposerPluginManager::class);

        if (isset($configuration['mt_mail']['composer_plugins'])
            && is_array($configuration['mt_mail']['composer_plugins'])
        ) {
            $eventManager = $service->getEventManager();
            foreach (array_unique($configuration['mt_mail']['composer_plugins']) as $plugin) {
                $pluginManager->get($plugin)->attach($eventManager);
            }
        }

        return $service;
    }
    
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->__invoke($serviceLocator,null);
    }
}
