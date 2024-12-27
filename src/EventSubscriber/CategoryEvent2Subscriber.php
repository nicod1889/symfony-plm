<?php

declare(strict_types= 1);

namespace App\EventSubscriber;

use App\Event\CategoryLoaded;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class CategoryEvent2Subscriber implements EventSubscriberInterface {
    public function __construct(private MailerInterface $mailer) {

    }

    public static function getSubscribedEvents(): array {
        return [
            CategoryLoaded::class => 'onCategoryLoaded',
        ];
    }

    public function onCategoryLoaded(CategoryLoaded $event): void {
        $email = (new Email())
                ->from('admin@api.com')
                ->to('juan@api.com')
                ->subject('CATEGORIAS CARGADAS')
                ->text('Se cargaron las categorias')
                ->html('<p>Se cargaron las categorias</p>');

        $this->mailer->send($email);
    }
}