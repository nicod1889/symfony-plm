<?php

namespace App\EventSubscriber;

use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class CheckRequirementsSubscriber implements EventSubscriberInterface {
    public function __construct(private EntityManagerInterface $entityManager) {
    }

    public static function getSubscribedEvents(): array {
        return [
            ConsoleEvents::ERROR => 'handleConsoleError',
            KernelEvents::EXCEPTION => 'handleKernelException',
        ];
    }

    public function handleConsoleError(ConsoleErrorEvent $event): void {
        $commandNames = ['doctrine:fixtures:load', 'doctrine:database:create', 'doctrine:schema:create', 'doctrine:database:drop'];
        if ($event->getCommand() && \in_array($event->getCommand()->getName(), $commandNames, true)) {
            if ($this->isSQLitePlatform() && !\extension_loaded('sqlite3')) {
                $io = new SymfonyStyle($event->getInput(), $event->getOutput());
                $io->error('This command requires to have the "sqlite3" PHP extension enabled because, by default, the Symfony Demo application uses SQLite to store its information.');
            }
        }
    }

    public function handleKernelException(ExceptionEvent $event): void {
        $exception = $event->getThrowable();
        $previousException = $exception->getPrevious();
        $isDriverException = ($exception instanceof DriverException || $previousException instanceof DriverException);
        if ($isDriverException && $this->isSQLitePlatform() && !\extension_loaded('sqlite3')) {
            $event->setThrowable(new \Exception('PHP extension "sqlite3" must be enabled because, by default, the Symfony Demo application uses SQLite to store its information.'));
        }
    }

    private function isSQLitePlatform(): bool {
        $databasePlatform = $this->entityManager->getConnection()->getDatabasePlatform();
        return $databasePlatform instanceof SQLitePlatform;
    }
}
