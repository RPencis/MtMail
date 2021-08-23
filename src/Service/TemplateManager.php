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
use MtMail\Template\TemplateInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;

class TemplateManager extends AbstractPluginManager
{

    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed            $plugin
     * @throws RuntimeException
     * @return void
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof TemplateInterface) {
            $class = get_class($plugin);
            throw new RuntimeException("E-mail template must implement TemplateInterface, '$class' was given.");
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
}
