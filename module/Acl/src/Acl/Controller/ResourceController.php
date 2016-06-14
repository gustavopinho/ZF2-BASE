<?php
namespace Acl\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractCrudRestfulController;
use Core\Service\ServiceInterface;

class ResourceController extends AbstractCrudRestfulController
{
    public function __construct(ServiceInterface $service)
    {
        $this->service      = $service;
        $this->form         = "Acl\Form\Resource";
    }

    public function getAllAction()
    {
        $list = $this->service
                        ->getRepository()
                        ->findAll();

        $entities = [];
        // Verificar essa parte do código para uma solução melhor
        foreach ($list as $key => $value) {
            array_push($entities, $value->toArray());
        }

        return new JsonModel([
            'messages' => [],
            'data' => [
                'entities' => $entities
            ],
        ]);
    }
}
