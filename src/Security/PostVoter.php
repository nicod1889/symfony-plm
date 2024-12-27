<?php

namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PostVoter extends Voter {
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const SHOW = 'show';

    protected function supports(string $attribute, mixed $subject): bool {
        return $subject instanceof Post && \in_array($attribute, [self::SHOW, self::EDIT, self::DELETE], true);
    }

    /**
     * @param Post $post
     */
    protected function voteOnAttribute(string $attribute, $post, TokenInterface $token): bool {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        return $user === $post->getAuthor();
    }
}
