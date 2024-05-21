<?php

declare(strict_types=1);

namespace Drupal\carousel;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\file\Entity\File;
use Drupal\file\Plugin\Field\FieldType\FileFieldItemList;
use Drupal\image\Plugin\Field\FieldType\ImageItem;
use Drupal\node\NodeInterface;

class Slide
{
    public function __construct(protected NodeInterface $entity)
    {
    }

    public function getTitle(): ?string
    {
        $title = $this->entity->label();
        if ($title instanceof TranslatableMarkup) {
            return $title->render();
        }

        return $title;
    }

    public function getUrl(): string
    {
        return $this->entity->toUrl()->toString();
    }

    public function getImageUri(): ?string
    {
        $imageEntity = null;
        /**
   * @var FileFieldItemList $imageField 
*/
        $imageField = $this->entity->get('field_image');

        if (!$imageField->isEmpty()) {
            $imageEntities = $imageField->referencedEntities();

            if (count($imageEntities) !== 0) {
                /**
     * @var File $image 
*/
                $image = $imageEntities[0];
                $imageEntity = $image->getFileUri();
            }
        }

        return $imageEntity;
    }

    public function getImageTitle(): ?string
    {
        $imageTitle = '';
        /**
   * @var FileFieldItemList $imageField 
*/
        $imageField = $this->entity->get('field_image');

        if (!$imageField->isEmpty()) {
            /**
     * @var ?ImageItem $imageItem 
*/
            $imageItem = $imageField->first();

            if ($imageItem !== null) {
                $imageTitle = $imageItem->get('alt')->getValue();
            }
        }

        return $imageTitle;
    }
}
