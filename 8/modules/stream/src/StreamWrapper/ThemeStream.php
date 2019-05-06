<?php

namespace Drupal\stream\StreamWrapper;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\StreamWrapper\LocalStream;
use Drupal\Core\StreamWrapper\StreamWrapperInterface;

/**
 * Defines a Drupal current theme (theme://) stream wrapper class.
 *
 * Provides support for storing theme accessible files with the Drupal file
 * interface.
 */
class ThemeStream extends LocalStream {

  /**
   * {@inheritdoc}
   */
  public static function getType() {
    return StreamWrapperInterface::LOCAL_NORMAL;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return t('Theme files');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return t('Current theme file served by the webserver.');
  }

  /**
   * {@inheritdoc}
   */
  public function getDirectoryPath() {
    return static::basePath();
  }

  /**
   * {@inheritdoc}
   */
  public function getExternalUrl() {
    $path = str_replace('\\', '/', $this->getTarget());
    return static::baseUrl() . '/' . UrlHelper::encodePath($path);
  }

  /**
   * Finds and returns the base URL for theme://.
   *
   * @return string
   *   The external base URL for theme://
   */
  public static function baseUrl() {
    return $GLOBALS['base_url'] . '/' . static::basePath();
  }

  /**
   * Returns the base path for theme://.
   *
   * @return string
   *   The base path for theme://.
   */
  public static function basePath() {
    return \Drupal::theme()->getActiveTheme()->getPath();
  }

}
