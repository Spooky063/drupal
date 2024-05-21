<?php

declare(strict_types=1);

namespace Drupal\carousel;

class CarouselDataProvider
{
    public function __construct(private ImageRepository $imageRepository, private ImageProcessor $imageProcessor)
    {
    }

    public function getCarouselImages(): ?array
    {
        $images = $this->imageRepository->getArticles();
        if ($images) {
            return $this->imageProcessor->processImages($images);
        }

        return null;
    }

}
