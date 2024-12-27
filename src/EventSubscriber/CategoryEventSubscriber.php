<?php

declare(strict_types= 1);

namespace App\EventSubscriber;

use App\Event\CategoryCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class CategoryEventSubscriber implements EventSubscriberInterface {

    public function __construct(
        private MailerInterface $mailer
    ) {

    }

    public static function getSubscribedEvents(): array {
        return [
            CategoryCreated::class => 'onCategoryCreated',
        ];
    }

    public function onCategoryCreated(CategoryCreated $event): void {
        $email = (new Email())
                ->from('admin@api.com')
                ->to('juan@api.com')
                ->subject('NEW CATEGORY')
                ->text('New category has been created')
                ->html('<p>New category has been created</p>');

        $this->mailer->send($email);
    }
}