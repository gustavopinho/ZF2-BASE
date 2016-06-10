<?php
namespace Core\Image;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Image($container->get('Image\Imagine'));
    }

    public function createService(ServiceLocatorInterface $services)
    {
        return $this($services, Image::class);
    }
}
