<?php
namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Class Privilege
 *
 * @ORM\Table(name="acl_privilege")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Acl\Repository\Privilege")
 */
class Privilege
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \Acl\Entity\Resource
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $resource;

    /**
     * @var \Acl\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @param array $options
     */
    public function __construct($options=[])
    {
        (new Hydrator\ClassMethods())->hydrate($options, $this);
        $this->setCreated()->setUpdated();
    }

    /**
     * Get the value of Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param integer id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Resource
     *
     * @return \Acl\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set the value of Resource
     *
     * @param \Acl\Entity\Resource resource
     *
     * @return self
     */
    public function setResource(\Acl\Entity\Resource $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the value of Role
     *
     * @return \Acl\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of Role
     *
     * @param \Acl\Entity\Role role
     *
     * @return self
     */
    public function setRole(\Acl\Entity\Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of Created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of Created
     *
     * @return self
     */
    public function setCreated()
    {
        $this->created = = new \DateTime("now");

        return $this;
    }

    /**
     * Get the value of Updated
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of Updated
     *
     * @ORM\PrePersist
     *
     * @return self
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");

        return $this;
    }

    /**
     * Get the values of Role
     *
     * @return array
     */
    public function toArray()
    {
        $array = (new Hydrator\ClassMethods())->extract($this);
        $array['role'] = $this->getRole()->getId();
        $array['resource'] = $this->getResource()->getId();
        return $array;
    }
}
