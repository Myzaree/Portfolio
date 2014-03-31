<?php

namespace App\Framework\Base;

use App\Utility\Steve;
use DCP\Di\Container;
use DCP\Di\ContainerAwareInterface;
use League\Plates\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller implements ContainerAwareInterface
{
    /** @var Container */
    protected $container;

    /** @var Request */
    protected $request;

    /** @var Template */
    protected $template;

    public function __construct(Request $request, Template $template)
    {
        Steve::note('Controller');

        $this->request = $request;
        $this->template = $template;
    }

    public function redirect($route)
    {
        $response = new RedirectResponse($route);
        $response->send();
    }

    public function render($path, $data = [])
    {
        return $this->template->render($path, $data);
    }

    public function response($template)
    {
        (new Response($template))->send();

        return $this;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
