<?php
namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Core\Service\AbstractService;

class Privilege extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Privilege';
    }
    public function persist(array $data, $id = null)
    {
        $data['role'] = $this->em->getReference('Acl\Entity\Role', $data['role']);
        $data['resource'] = $this->em->getReference('Acl\Entity\Resource', $data['resource']);
        return parent::persist($data, $id);
    }
}
