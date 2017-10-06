<?php

namespace TaskPlannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name = "mainNotDone")
     */
    public function indexAction()
    {
        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Task');
        $tasks = $repo->findBy(['user' => $user, 'isDone' => false]);
        return $this->render('TaskPlannerBundle:Default:index.html.twig', array(
            'tasks' => $tasks,
            'done' => 0));
    }

    /**
     * @Route("/done", name = "mainDone")
     */
    public function indexDoneAction()
    {
        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Task');
        $tasks = $repo->findBy(['user' => $user, 'isDone' => true]);
        return $this->render('TaskPlannerBundle:Default:index.html.twig', array(
            'tasks' => $tasks,
             'done' => 1 ));
    }


    /**
     * @Route("/mail/{n}", name="mail")
     */
    public function sendEmailAction($n)
    {
        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Task');
        if($n == 0) {
            $tasks = $repo->findBy(['user' => $user, 'isDone' => false]);
        }elseif ($n == 1) {
            $tasks = $repo->findBy(['user' => $user, 'isDone' => true]);
        }

        $to = $this->getUser()->getEmail();
        $message = \Swift_Message::newInstance()
            ->setSubject("Tasks")
            ->setFrom('nipepsi90@gmail.com')
            ->setTo($to)
            ->setBody($this->renderView('Task/showAll.html.twig', ['tasks' => $tasks]),
                'text/html');
//            ->setBody("HALO");
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('mainNotDone');

    }
}
