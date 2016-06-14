<?php
namespace Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = new Role;
        $role->setName("Guests");
        $manager->persist($role);
        $guest = $manager->getReference('Acl\Entity\Role', 1);

        $role = new Role;
        $role->setName("Users")->setParent($guest);
        $manager->persist($role);
        $users = $manager->getReference('Acl\Entity\Role', 2);

        $role = new Role;
        $role->setName("Administrators")->setParent($users);
        $manager->persist($role);

        $role = new Role;
        $role->setName("Developers")->setDeveloper(1);
        $manager->persist($role);
        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
