<?php

namespace App\EventSubscriber;

use App\Twig\SourceCodeExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ControllerSubscriber implements EventSubscriberInterface {
    public function __construct(
        private SourceCodeExtension $twigExtension
    ) {
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::CONTROLLER => 'registerCurrentController',
        ];
    }

    public function registerCurrentController(ControllerEvent $event): void {
        if ($event->isMainRequest()) {
            $this->twigExtension->setController($event->getController());
        }
    }
}
