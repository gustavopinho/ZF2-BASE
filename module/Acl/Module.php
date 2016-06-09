<?php
namespace Acl;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(

            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Acl\Service\Role' => function ($sm) {
                    return new Service\Role($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Acl\Service\Resource' => function ($sm) {
                    return new Service\Resource($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Acl\Service\Privilege' => function ($sm) {
                    return new Service\Privilege($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Acl\Permissions\Acl' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');

                    $repoRole = $em->getRepository("Acl\Entity\Role");
                    $roles = $repoRole->findAll();

                    $repoResource = $em->getRepository("Acl\Entity\Resource");
                    $resources = $repoResource->findAll();

                    $repoPrivilege = $em->getRepository("Acl\Entity\Privilege");
                    $privilege = $repoPrivilege->findAll();

                    return new Permissions\Acl($roles, $resources, $privilege);
                }
            )
        );
    }
}
