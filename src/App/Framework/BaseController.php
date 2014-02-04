<?php

namespace App\Framework;

use DCP\Di\Container;
use DCP\Di\ContainerAwareInterface;
use League\Plates\Template;

class BaseController implements ContainerAwareInterface
{
    /** @var Container $container */
    protected $container;

    /** @var Template $template */
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function render($path, $data = [])
    {
        return $this->template->render($path, $data);
    }

    /**
     * Add a reference of the container to the service.
     *
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
