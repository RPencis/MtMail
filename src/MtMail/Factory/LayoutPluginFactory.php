<?php

namespace MtMail\Factory;

use MtMail\Plugin\Layout;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LayoutPluginFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Configuration');
        $plugin = new Layout();
        if (isset($config['mt_mail']['layout_plugin']['layout_template'])) {
            $plugin->setLayoutTemplate($config['mt_mail']['layout_plugin']['layout_template']);
        }
        return $plugin;
    }
}