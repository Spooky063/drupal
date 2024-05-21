<?php

declare(strict_types=1);

namespace Drupal\notify\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\notify\Teams\AdaptiveCards\Elements\ActionOpenUrl;
use Drupal\notify\Teams\AdaptiveCards\Elements\ActionSet;
use Drupal\notify\Teams\AdaptiveCards\Elements\Column;
use Drupal\notify\Teams\AdaptiveCards\Elements\ColumnSet;
use Drupal\notify\Teams\AdaptiveCards\Elements\TextBlock;
use Drupal\notify\Teams\AdaptiveCards\Message;
use Drupal\notify\Teams\TeamsWebhookWrapper;

final class TestAdaptiveCardsController extends ControllerBase implements ContainerInjectionInterface
{
    public function __construct(
        private TeamsWebhookWrapper $teamsWebhook,
    ) {
    }

    public static function create(ContainerInterface $container): self
    {
        return new static(
            $container->get('teams.service')
        );
    }

    public function __invoke(): void
    {
        $message = new Message();
        $message->addBodyElement(
            new TextBlock('Title', ['size' => 'Medium', 'weight' => 'Bolder'])
        );

        $columnSet = new ColumnSet();
        $column = new Column(['width' => 'stretch']);
        $column->addItem(new TextBlock('John Doe', ['weight' => 'Bolder', 'wrap' => 'true']));
        $column->addItem(new TextBlock('Created now', ['spacing' => 'None', 'isSubtle' => 'true', 'wrap' => 'true']));
        $columnSet->addElement($column);
        $message->addBodyElement($columnSet);

        $message->addBodyElement(
            new TextBlock('Content', ['wrap' => 'true'])
        );

        $actionSet = new ActionSet();
        $action = new ActionOpenUrl('View', 'https://google.com/');
        $actionSet->addAction($action);
        $message->addBodyElement($actionSet);

        $this->teamsWebhook->notify($message);
    }
}
