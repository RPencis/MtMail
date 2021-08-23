<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMailTest\Renderer;

use MtMail\Renderer\ZendView;
use PHPUnit\Framework\TestCase;
use Laminas\View\Model\ViewModel;

class LaminasViewTest extends TestCase
{
    public function testRenderSetsViewModelAndCallsLaminasViewRender()
    {
        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->setOption('has_parent', true)->shouldBeCalled();

        $view = $this->prophesize(\Laminas\View\View::class);
        $view->render($viewModel->reveal());

        $renderer = new LaminasView($view->reveal());
        $renderer->render($viewModel->reveal());
    }
}
