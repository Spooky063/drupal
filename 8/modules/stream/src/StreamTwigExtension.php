<?php

namespace Drupal\stream;

class StreamTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'stream';
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('media', [$this, 'media'])
    ];
  }

  /**
   * Return the URL for specific media.
   * 
   * @code
   * {{ media('theme://images/img.ext') }}
   * @endcode
   * 
   * @param $file string
   *   The complete relative file path with scheme.
   * @param $absolute boolean
   *   Create an absolute path.
   * 
   * @return string
   *   The media path.
   */
  public function media($file, $absolute = false) {
    global $base_path;

    $scheme = file_uri_scheme($file);

    $wrapper = \Drupal::service('stream_wrapper_manager')->getViaScheme($scheme);
    if ($absolute) {
      return $wrapper->getExternalUrl() . file_uri_target($file);
    }

    $path = $wrapper->getDirectoryPath() . '/' . file_uri_target($file);

    return $base_path . $path;
  }

}
