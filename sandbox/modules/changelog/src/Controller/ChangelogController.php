<?php

declare(strict_types=1);

namespace Drupal\changelog\Controller;

use Drupal\changelog\Service\ChangelogPageService;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChangelogController extends ControllerBase implements ContainerInjectionInterface
{
  protected ChangelogPageService $changelogPageService;

  public function __construct(ChangelogPageService $changelogPageService)
  {
    $this->changelogPageService = $changelogPageService;
  }

  public static function create(ContainerInterface $container): self
  {
    return new static(
      $container->get('changelog.service')
    );
  }

  public function __invoke(): array
  {
    $items = $this->changelogPageService->getAllChangelogOrderByReleaseDate();

    $build = [
      '#theme' => 'changelog_page',
      '#items' => $items,
      '#cache' => [
        'contexts' => [
          'url.path',
          'url.query_args'
        ],
      ]
    ];
    $build['#attached']['library'][] = 'changelog/page';

    return $build;
  }
}
