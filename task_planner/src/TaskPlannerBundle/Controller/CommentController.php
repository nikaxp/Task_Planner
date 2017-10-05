<?php

namespace TaskPlannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TaskPlannerBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TaskPlannerBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use TaskPlannerBundle\Entity\Task;

/**
 * Class CommentController
 * @Route("/comment")
 */

class CommentController extends Controller
{
    /**
     * @Route("/new/{taskId}", name = "newComment")
     * @Method("POST")
     */
    public function newCommentAction(Request $request, $taskId)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $repo = $this->getDoctrine()
                ->getRepository('TaskPlannerBundle:Task');
            $task = $repo->find($taskId);
            $added = new \DateTime("now");

            $comment->setTask($task);
            $comment->setAdded($added);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('showTask', array(
                'id' => $task->getId()
            ));
        }

        return new Response("Incorrect data. Try create Comment again.");


    }


}
