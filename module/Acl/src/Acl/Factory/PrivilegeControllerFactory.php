<?php
namespace Acl\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Acl\Controller\PrivilegeController;

class PrivilegeControllerFactory implements FactoryInterface
{
    /**
     * Implemetação para versão 3
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PrivilegeController($container->get('Acl\Service\Privilege'));
    }

    public function createService(ServiceLocatorInterface $services)
    {
        $service = $services->getServiceLocator();
        return new PrivilegeController($service->get('Acl\Service\Privilege'));
    }
}
