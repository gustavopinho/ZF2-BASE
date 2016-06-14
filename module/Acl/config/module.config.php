<?php

namespace Acl;

return array(
        'router' => array(
        'routes' => array(
            'api-acl' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/acl',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Acl\Controller',
                        'controller' => 'Role',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:controller[/:action][/:id]].json',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Acl\Controller',
                                'controller' => 'Role'
                            ),
                        ),
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:controller[/page/:page]].json',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Acl\Controller',
                                'controller' => 'Role'
                            ),
                        ),
                    ),
                    'teste' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/test.json',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Acl\Controller',
                                'controller' => 'Role',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            )
        )
    ),
    'service_manager' => array(
         'invokables' => array(
            //'Acl\Service\ResourceServiceInterface' => 'Acl\Service\Resource'
         )
     ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Acl\Controller\Role' => 'Acl\Factory\RoleControllerFactory',
            'Acl\Controller\Resource' => 'Acl\Factory\ResourceControllerFactory',
            'Acl\Controller\Privilege' => 'Acl\Factory\PrivilegeControllerFactory',
         )
    ),
    'view_manager' => array(
        'doctype' => 'HTML5',
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        __NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
    ),
);
