<?php
namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Core\Service\AbstractService;

class Resource extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Resource';
    }
}
