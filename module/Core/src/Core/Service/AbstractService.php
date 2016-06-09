<?php
namespace Core\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @param EntityManager $em [description]
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getRepository()
    {
        return $this->getEntityManager()
                    ->getRepository($this->entity);
    }

    public function persist(array $data, $id=null)
    {
        if ($id) {
            $entity = $this->getEntityManager()
                            ->getReference($this->entity, $id);
            (new Hydrator\ClassMethods())->hydrate($data, $entity);
        } else {
            $entity = new $this->entity($data);
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function delete($id)
    {
        $entity = $this->getEntityManager()
                        ->getReference($this->entity, $id);
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }
}
