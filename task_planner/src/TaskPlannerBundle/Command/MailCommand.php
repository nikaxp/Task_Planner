<?php
/**
 * Created by PhpStorm.
 * User: nika
 * Date: 05.10.17
 * Time: 15:13
 */
namespace TaskPlannerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class MailCommand extends Command
{
    protected function configure()
    {
        $this ->setName('send:email')
            ->setDescription('Send email')
            ->addArgument('emailTo',
                InputArgument::REQUIRED,
                'What\'s the recipient email address?')
            ->addArgument('subject',
                InputArgument::REQUIRED,
                'What\'s the email subject?')
            ->addArgument('date',
                InputArgument::OPTIONAL,
                'What\'s the date?'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailTo = $input->getArgument('emailTo');

        $subject = $input->getArgument('subject');

        if ($emailTo) {

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(TaskPlanner)
                ->setTo('nipepsi90@wp.pl')
                ->setBody('You have to do tasks.')
            ;
            $this->get('mailer')->send($message);

        }



        $output->writeln('emailTo: ' . $input->get);

    }
}
