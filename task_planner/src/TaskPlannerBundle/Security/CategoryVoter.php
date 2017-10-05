<?php

namespace TaskPlannerBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use TaskPlannerBundle\Entity\Category;
use TaskPlannerBundle\Entity\User;

class CategoryVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof Category) {
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
    /** @var Category $category */
    $category = $subject;

    switch($attribute) {
        case self::VIEW:
            return $this->canView($category, $user);
        case self::EDIT:
            return $this->canEdit($category, $user);
    }

    throw new \LogicException('This code should not be reached!');
    }

    private function canView(Category $category, User $user)
    {
        if ($this->canEdit($category, $user)) {
            return true;
        }

        return false;
    }

    private function canEdit(Category $category, User $user)
    {
        return $user === $category->getUser();
    }
}