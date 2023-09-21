<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards;

use Drupal\notify\Teams\AdaptiveCards\Contract\ActionRenderable;
use Drupal\notify\Teams\AdaptiveCards\Contract\ElementRenderable;
use Drupal\notify\Teams\AdaptiveCards\Contract\MessageRenderable;

final class Message implements MessageRenderable
{
    private array $bodyElements = [];

    private array $actions = [];

    public function render(): array
    {
        $build = [
            'type' => 'message',
            'attachments' => [
                [
                    'contentType' => 'application/vnd.microsoft.card.adaptive',
                    'contentUrl' => null,
                    'content' => [
                        '$schema' => 'http://adaptivecards.io/schemas/adaptive-card.json',
                        'type' => 'AdaptiveCard',
                        'version' => '1.2',
                    ]
                ]
            ]
        ];

        foreach ($this->bodyElements as $bodyElement) {
            $build['attachments'][0]['content']['body'][] = $bodyElement->render();
        }

        foreach ($this->actions as $action) {
            $build['attachments'][0]['content']['actions'][] = $action->render();
        }

        return $build;
    }

    public function addBodyElement(ElementRenderable $bodyElement): void
    {
        $this->bodyElements[] = $bodyElement;
    }

    public function addAction(ActionRenderable $action): void
    {
        $this->actions[] = $action;
    }
}
