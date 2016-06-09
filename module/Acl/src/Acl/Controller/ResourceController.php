<?php
namespace Acl\Controller;

use Core\Controller\AbstractCrudRestfulController;
use Core\Service\ServiceInterface;

class ResourceController extends AbstractCrudRestfulController
{
    public function __construct(ServiceInterface $service)
    {
        $this->service      = $service;
        $this->form         = "Acl\Form\Resource";
    }
}
