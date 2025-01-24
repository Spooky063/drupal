<?php

declare(strict_types=1);

namespace Drupal\queue\Plugin\QueueWorker;

/**
 * Throw this exception to release the item allowing it to be processed again.
 */
final class ArticleQueueException extends \RuntimeException
{
}
