<?php
namespace Acl\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Acl\Controller\RoleController;

class RoleControllerFactory implements FactoryInterface
{
    /**
     * Implemetação para versão 3
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RoleController($container->get('Acl\Service\Role'));
    }

    public function createService(ServiceLocatorInterface $services)
    {
        $service = $services->getServiceLocator();
        return new RoleController($service->get('Acl\Service\Role'));
    }
}
