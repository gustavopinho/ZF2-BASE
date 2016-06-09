<?php
namespace Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Acl\Entity\Privilege;

class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $guest  = $manager->getReference('Acl\Entity\Role', 1);
        $users  = $manager->getReference('Acl\Entity\Role', 2);
        $admin  = $manager->getReference('Acl\Entity\Role', 3);

        $roleResource       = $manager->getReference('Acl\Entity\Resource', 1);
        $resourceResource   = $manager->getReference('Acl\Entity\Resource', 2);
        $privilegeResource  = $manager->getReference('Acl\Entity\Resource', 3);

        // Administrators
        $privilege = new Privilege;
        $privilege->setName("All")->setRole($admin)->setResource($roleResource);
        $manager->persist($privilege);
        $privilege->setName("All")->setRole($admin)->setResource($resourceResource);
        $manager->persist($privilege);
        $privilege->setName("All")->setRole($admin)->setResource($privilegeResource);
        $manager->persist($privilege);
        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }
}
