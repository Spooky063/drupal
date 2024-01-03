<?php

declare(strict_types=1);

namespace Drupal\carousel\Controller;

use Drupal\carousel\CarouselDataProvider;
use Drupal\carousel\CarouselRenderer;
use Drupal\carousel\ImageProcessor;
use Drupal\carousel\ImageRepository;

class CarouselController
{
    public function __invoke(): array
    {
        $entityTypeManager = \Drupal::service('entity_type.manager');
        $imageRepository = new ImageRepository($entityTypeManager);
        $imageProcessor = new ImageProcessor();
        $carouselRenderer = new CarouselRenderer();

        $carouselDataProvider = new CarouselDataProvider($imageRepository, $imageProcessor);
        $carouselImages = $carouselDataProvider->getCarouselImages();
        return $carouselRenderer->renderCarousel($carouselImages);
    }
}
