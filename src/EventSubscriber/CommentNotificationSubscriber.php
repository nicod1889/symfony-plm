<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use App\Entity\User;
use App\Event\CommentCreatedEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class CommentNotificationSubscriber implements EventSubscriberInterface {
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private TranslatorInterface $translator,
        #[Autowire('%app.notifications.email_sender%')]
        private string $sender
    ) {
    }

    public static function getSubscribedEvents(): array {
        return [
            CommentCreatedEvent::class => 'onCommentCreated',
        ];
    }

    public function onCommentCreated(CommentCreatedEvent $event): void {
        $comment = $event->getComment();
        /** @var Post $post */
        $post = $comment->getPost();
        /** @var User $author */
        $author = $post->getAuthor();
        /** @var string $emailAddress */
        $emailAddress = $author->getEmail();
        $linkToPost = $this->urlGenerator->generate('blog_post', [
            'slug' => $post->getSlug(),
            '_fragment' => 'comment_'.$comment->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        $subject = $this->translator->trans('notification.comment_created');
        $body = $this->translator->trans('notification.comment_created.description', [
            'title' => $post->getTitle(),
            'link' => $linkToPost,
        ]);
        $email = (new Email())
            ->from($this->sender)
            ->to($emailAddress)
            ->subject($subject)
            ->html($body)
        ;
        $this->mailer->send($email);
    }
}
