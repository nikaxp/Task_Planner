<?php

namespace TaskPlannerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="TaskPlannerBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="text", type="text")
     * @Assert\Length(
     *     max = 200,
     *     maxMessage = "Comment is too long. It should have {{ limit }} characters or less."
     * )
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added", type="datetime")
     */
    private $added;

    /**
     * @ORM\ManyToOne(targetEntity = "Task", inversedBy="comments")
     * @ORM\JoinColumn(name = "task_id", referencedColumnName = "id", nullable = true)
     */
    private $task;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     *
     * @return Comment
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set task
     *
     * @param \TaskPlannerBundle\Entity\Task $task
     *
     * @return Comment
     */
    public function setTask(\TaskPlannerBundle\Entity\Task $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \TaskPlannerBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }
}
