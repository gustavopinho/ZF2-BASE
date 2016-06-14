<?php

namespace Acl\Service;

use Core\Service\AbstractService;

class Role extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Role';
    }
    public function persist(array $data, $id = null)
    {
        $data['parent'] = (empty($data['parent']) or $data['parent'] == 'null') ? null : $this->em->getReference($this->entity, $data['parent']);

        return parent::persist($data, $id);
    }
}
