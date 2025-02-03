<?php

declare(strict_types=1);

namespace Drupal\sse_notify\EventSubscriber;

use Drupal\Core\Session\AccountInterface;
use Drupal\sse_notify\NodeEventService;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mercure\Jwt\LcobucciFactory;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Mercure\Jwt\TokenFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class MercureCookieEventSubscriber implements EventSubscriberInterface
{
    private readonly TokenFactoryInterface $tokenFactory;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly AccountInterface $currentUser,
        private readonly Authorization $authorization,
    ) {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            throw new \RuntimeException('A request must be available');
        }

      /** @var string $secret */
        $secret = $request->server->get('MERCURE_SUBSCRIBER_SECRET');
        assert(!empty($secret), new \RuntimeException('Mercure subscriber secret should not be empty'));

        $this->tokenFactory = new LcobucciFactory($secret);
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['setMercureCookie', 130],
        ];
    }

    public function setMercureCookie(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        if (
            HttpKernelInterface::MAIN_REQUEST !== $event->getRequestType()
            || !in_array('text/html', $request->getAcceptableContentTypes())
        ) {
            return;
        }

        $exp = (new \DateTimeImmutable('+1 hour'));
        $tokenValue = $this->getTokenValue($exp);
        $cookie = $this->authorization->createClearCookie($request, null)
            ->withExpires($exp)
            ->withValue($tokenValue);
        $response->headers->setCookie($cookie);

        $event->setResponse($response);
    }

    private function getTokenValue(\DateTimeImmutable $date): string
    {
        return $this->tokenFactory->create(
            $this->getTopics(),
            null,
            ['exp' => new \DateTimeImmutable('@' . $date->getTimestamp())]
        );
    }

    /**
     * @return array<string>
     */
    private function getTopics(): array
    {
        $topics = [];

        if ($this->currentUser->hasPermission('administer nodes')) {
            $topics[] = NodeEventService::NODE_UPDATE_TOPIC;
        }

        return $topics;
    }
}
