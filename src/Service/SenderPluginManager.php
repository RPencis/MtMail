<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMail\Service;

use MtMail\Exception\RuntimeException;
use MtMail\SenderPlugin\PluginInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;

class SenderPluginManager extends AbstractPluginManager
{

    /**
     * The main service locator
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Validate the plugin
     *
     *
     * @param  mixed            $plugin
     * @throws RuntimeException
     * @return void
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof PluginInterface) {
            throw new RuntimeException(sprintf(
                'Plugin of type %s is invalid; must implement %s\FilterInterface or be callable',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            ));
        }
    }

    /**
     * sm v3
     * @param  mixed   $plugin
     * @return void
     */
    public function validate($plugin)
    {
        $this->validatePlugin($plugin);
    }

    /**
     * Canonicalize name
     *
     * @param  string $name
     * @return string
     */
    protected function canonicalizeName($name)
    {
        return $name;
    }
}
