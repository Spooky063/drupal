<?php

declare(strict_types=1);

namespace Drupal\carousel;

use Drupal\image\Entity\ImageStyle;

class ImageProcessor
{
    /**
     * @param array<int, Slide> $images
     */
    public function processImages($images): array
    {
        /**
   * @var ImageStyle $style 
*/
        $style = \Drupal::entityTypeManager()->getStorage('image_style')->load('thumbnail');

        $slides = [];
        foreach ($images as $image) {
            $slides[] = [
            'slideTitle' => $image->getTitle(),
            'slideUrlRedirect' => $image->getUrl(),
            'slideImageAlt' => $image->getImageTitle(),
            'slideImageUrl' => $image->getImageUri() ? $style->buildUrl($image->getImageUri()) : '',
            ];
        }

        return $slides;
    }
}
