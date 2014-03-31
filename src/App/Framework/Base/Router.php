<?php

namespace App\Framework\Base;

use DCP\Di\Container;
use DCP\Di\ContainerAwareInterface;
use DCP\Router\ControllerEvents;
use DCP\Router\ComponentEvents;
use DCP\Router\Event\CreateEvent;
use DCP\Router\MvcRouter;

class Router extends MvcRouter implements ContainerAwareInterface
{
    /** @var Container */
    protected $container;

    public function __construct()
    {
        parent::__construct();

        $createCallback = function (CreateEvent $event) {
            /** @var Container $container */
            $container = $this->container;
            $class = $event->getClass();
            $event->setInstance($container->get($class));
        };

        $this->removeAllListeners(ControllerEvents::CREATE);
        $this->on(ControllerEvents::CREATE, $createCallback);

        $this->removeAllListeners(ComponentEvents::CREATE);
        $this->on(ComponentEvents::CREATE, $createCallback);
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
