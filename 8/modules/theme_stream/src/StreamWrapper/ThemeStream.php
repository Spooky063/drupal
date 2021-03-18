<?php

namespace Drupal\theme_stream\StreamWrapper;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\StreamWrapper\LocalStream;
use Drupal\Core\StreamWrapper\StreamWrapperInterface;

class ThemeStream extends LocalStream
{
    public static function getType(): int
    {
        return StreamWrapperInterface::LOCAL_NORMAL;
    }

    public function getName(): string
    {
        return 'Theme files';
    }

    public function getDescription(): string
    {
        return 'Current theme file served by the webserver.';
    }

    public function getDirectoryPath(): string
    {
        return static::basePath();
    }

    public function getExternalUrl(): string
    {
        if ($this->getTarget() === false) {
            return '';
        }

        $path = str_replace('\\', '/', (string) $this->getTarget());

        return static::baseUrl() . '/' . UrlHelper::encodePath($path);
    }

    public static function baseUrl(): string
    {
        return $GLOBALS['base_url'] . '/' . static::basePath();
    }

    public static function basePath(): string
    {
        return \Drupal::theme()->getActiveTheme()->getPath();
    }
}
