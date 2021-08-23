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
use MtMail\Renderer\ZendView;

class LaminasViewRendererFactory
{
    public function __invoke(ContainerInterface $serviceLocator)
    {
        $view = $serviceLocator->get('ViewManager')->getView();
        $service = new LaminasView($view);

        return $service;
    }
}
