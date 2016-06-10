<?php
namespace Core;

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
                'flashMessenger' => function ($sm) {
                    $flashmessenger = $sm->getServiceLocator()
                                            ->get('ControllerPluginManager')
                                            ->get('flashmessenger');
                    return new View\Helper\FlashMessenger($flashmessenger);
                },
            ),
        );
    }
}
