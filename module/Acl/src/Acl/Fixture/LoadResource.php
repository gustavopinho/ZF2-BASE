<?php
namespace Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Acl\Entity\Resource;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /*id = 1*/
        $resource = new Resource;
        $resource->setName("Acl\Controller\Role");
        $manager->persist($resource);
        /*id = 2*/
        $resource = new Resource;
        $resource->setName("Acl\Controller\Resource");
        $manager->persist($resource);
        /*id = 3*/
        $resource = new Resource;
        $resource->setName("Acl\Controller\Privilege");
        $manager->persist($resource);
        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}
