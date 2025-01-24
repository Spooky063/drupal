<?php

declare(strict_types=1);

namespace Drupal\queue\Plugin\QueueWorker;

use Drupal;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\Attribute\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\queue\Queue\ArticleQueue;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[QueueWorker(
    id: self::PLUGIN_ID,
    title: new TranslatableMarkup('Article Queue'),
    cron: ['time' => 60]
)]
class ArticleQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface
{
    use StringTranslationTrait;

    public const PLUGIN_ID = 'article_queue';

    protected LoggerChannelInterface $logger;

    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition,
    ): self {
        $instance = new self($configuration, $plugin_id, $plugin_definition);
        $instance->logger = $container->get('logger.factory')->get('queue');
        return $instance;
    }

  /**
   * @throws ArticleQueueException
   */
    public function processItem($data): void
    {
        if (!$data instanceof ArticleQueue) {
          /** @phpstan-ignore-next-line */
            $state = \Drupal::state();
            if (!$state->get('queue_requeue_exception')) {
                $state->set('queue_requeue_exception', 1);
                throw new ArticleQueueException('Invalid data');
            }
            return;
        }

        $this->logger->info($this->t('Processed simple queue item @title', ['@title' => $data->getTitle()]));
    }
}
