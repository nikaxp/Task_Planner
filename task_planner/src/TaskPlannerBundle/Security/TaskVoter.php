<?php

namespace TaskPlannerBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use TaskPlannerBundle\Entity\Task;
use TaskPlannerBundle\Entity\User;

class TaskVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof Task) {
        return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

    // you know $subject is a Person object, thanks to supports
    /** @var Task $task */
    $task = $subject;

    switch($attribute) {
        case self::VIEW:
            return $this->canView($task, $user);
        case self::EDIT:
            return $this->canEdit($task, $user);
    }

    throw new \LogicException('This code should not be reached!');
    }

    private function canView(Task $task, User $user)
    {
        if ($this->canEdit($task, $user)) {
            return true;
        }

        return false;
    }

    private function canEdit(Task $task, User $user)
    {
        return $user === $task->getUser();
    }
}