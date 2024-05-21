<?php

declare(strict_types=1);

namespace Drupal\carousel;

class CarouselRenderer
{
    public function renderCarousel(?array $images): array
    {
        // TODO: do something with images
        dump($images);

        return ['#markup' => 'Do something!'];
    }
}
