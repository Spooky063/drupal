<?php

declare(strict_types=1);

namespace Drupal\ckeditor_codeblock_highlight\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;

final class HighlightService
{
    protected ImmutableConfig $config;

    public function __construct(
        ConfigFactoryInterface $configFactory
    ) {
        $this->config = $configFactory->get('ckeditor_codeblock_highlight.settings');
    }

    public function getHighlightTheme(): string
    {
        return $this->config->get('theme') ?? 'default';
    }
}
