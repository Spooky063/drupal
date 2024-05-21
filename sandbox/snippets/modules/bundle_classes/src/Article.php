<?php

declare(strict_types=1);

namespace Drupal\bundle_classes;

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\image\Plugin\Field\FieldType\ImageItem;
use Drupal\node\Entity\Node;

class Article extends Node implements ArticleInterface
{
    use NodeWithTagsTrait;

    public function getBody(): string
    {
        return $this->get('body')->value;
    }

    public function getImage(string $style = 'thumbnail'): ?string
    {
        $imageField = $this->get('field_image')->first();
        if (!$imageField instanceof ImageItem) {
            return null;
        }

        $imageEntity = File::load($imageField->get('target_id')->getValue());
        if (!$imageEntity) {
            return null;
        }

        $imageUri = $imageEntity->getFileUri();
        $imageStyle = ImageStyle::load($style);
        if (!$imageStyle) {
            return null;
        }

        return $imageStyle->buildUrl($imageUri);
    }
}
