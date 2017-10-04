<?php

namespace TaskPlannerBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="TaskPlannerBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity = "Category", mappedBy = "user")
     */
    private $categories;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Add category
     *
     * @param \TaskPlannerBundle\Entity\Category $category
     *
     * @return User
     */
    public function addCategory(\TaskPlannerBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \TaskPlannerBundle\Entity\Category $category
     */
    public function removeCategory(\TaskPlannerBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
