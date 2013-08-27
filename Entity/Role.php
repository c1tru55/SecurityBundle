<?php

namespace ITE\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass="RoleRepository")
 * @ORM\Table(name="ite_role", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="role_idx", columns={"name"})
 * })
 * @DoctrineAssert\UniqueEntity({"name"})
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ITE\SecurityBundle\Entity\Permission", inversedBy="roles")
     * @ORM\JoinTable(name="ite_roles_permissions")
     */
    protected $permissions;

    /**
     *
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ArrayCollection $permissions
     */
    public function setPermissions(ArrayCollection $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

}