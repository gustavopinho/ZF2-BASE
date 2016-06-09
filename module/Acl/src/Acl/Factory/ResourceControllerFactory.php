<?php
namespace Acl\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Acl\Controller\ResourceController;

class ResourceControllerFactory implements FactoryInterface
{
    /**
     * Implemetação para versão 3
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ResourceController($container->get('Acl\Service\Resource'));
    }

    public function createService(ServiceLocatorInterface $services)
    {
        $service = $services->getServiceLocator();
        return new ResourceController($service->get('Acl\Service\Resource'));
    }
}
