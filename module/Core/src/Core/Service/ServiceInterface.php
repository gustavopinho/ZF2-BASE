<?php
namespace Core\Service;

interface ServiceInterface
{
    /**
     * @return this entity
     */
    public function getEntity();

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager();

    /**
     * @return Doctrine\ORM\EntityManager\Repository
     */
    public function getRepository();

    /**
     * Updade and Create entity
     * @param  array  $data
     * @param  intenger/string $id
     * @return entity/null
     */
    public function persist(array $data, $id = null);

    /**
     * Delete entity
     * @param  intenger/string $id [description]
     * @return $id/null
     */
    public function delete($id);
}
