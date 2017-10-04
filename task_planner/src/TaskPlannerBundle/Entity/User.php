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

    /**
     * @ORM\OneToMany(targetEntity = "Task", mappedBy = "user")
     */
    private $tasks;


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

    /**
     * Add task
     *
     * @param \TaskPlannerBundle\Entity\Task $task
     *
     * @return User
     */
    public function addTask(\TaskPlannerBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \TaskPlannerBundle\Entity\Task $task
     */
    public function removeTask(\TaskPlannerBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
