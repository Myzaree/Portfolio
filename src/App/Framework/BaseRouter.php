<?php

namespace App\Framework;

use DCP\Di\Container;
use DCP\Di\ContainerAwareInterface;
use DCP\Router\ControllerEvents;
use DCP\Router\ComponentEvents;
use DCP\Router\Event\CreateEvent;
use DCP\Router\MvcRouter;

class BaseRouter extends MvcRouter implements ContainerAwareInterface
{
    protected $container;

    public function __construct()
    {
        parent::__construct();

        $createCallback = function (CreateEvent $event) {
            $container = $this->container;
            $class = $event->getClass();
            $event->setInstance($container->get($class));
        };

        $this->removeAllListeners(ControllerEvents::CREATE);
        $this->on(ControllerEvents::CREATE, $createCallback);

        $this->removeAllListeners(ComponentEvents::CREATE);
        $this->on(ComponentEvents::CREATE, $createCallback);
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
