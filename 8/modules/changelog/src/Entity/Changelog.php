<?php

declare(strict_types=1);

namespace Drupal\changelog\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the changelog entity class.
 *
 * @ContentEntityType(
 *   id = "changelog",
 *   label = @Translation("Changelog"),
 *   label_collection = @Translation("Changelog"),
 *   label_singular = @Translation("changelog item"),
 *   label_plural = @Translation("changelog items"),
 *   label_count = @PluralTranslation(
 *     singular = "@count changelog item",
 *     plural = "@count changelog items"
 *   ),
 *   handlers = {
 *     "storage" = "Drupal\changelog\ChangelogStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\changelog\ChangelogListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\changelog\ChangelogAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\changelog\Form\ChangelogForm",
 *       "edit" = "Drupal\changelog\Form\ChangelogForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "changelog",
 *   data_table = "changelog_field_data",
 *   translatable = TRUE,
 *   admin_permission = "access changelog overview",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "published" = "status",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "add-form" = "/admin/content/changelog/add",
 *     "edit-form" = "/admin/content/changelog/{changelog}/edit",
 *     "delete-form" = "/admin/content/changelog/{changelog}/delete",
 *     "collection" = "/admin/content/changelog"
 *   },
 * )
 */
class Changelog extends ContentEntityBase implements ChangelogInterface
{
  use EntityChangedTrait;
  use EntityOwnerTrait;
  use EntityPublishedTrait;

  public static function preCreate(
    EntityStorageInterface $storage_controller,
    array &$values,
  ): void
  {
    parent::preCreate($storage_controller, $values);
    $values += ['uid' => \Drupal::currentUser()->id()];
  }

  public static function baseFieldDefinitions(
    EntityTypeInterface $entity_type,
  ): array
  {
    /** @var FieldDefinitionInterface $fields */
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields += static::publishedBaseFieldDefinitions($entity_type);
    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields['release'] = BaseFieldDefinition::create('datetime')
      ->setTranslatable(true)
      ->setLabel(t('Release date')->render())
      ->setRequired(true)
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => -9,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'settings' => [
          'format_type' => 'medium',
        ],
        'weight' => -9,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setTranslatable(true)
      ->setLabel(t('Title')->render())
      ->setRequired(true)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type'   => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayOptions('view', [
        'type'   => 'string',
        'label'  => 'hidden',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', true);

    $fields['content'] = BaseFieldDefinition::create('text_long')
      ->setTranslatable(true)
      ->setLabel(t('Content')->render())
      ->setRequired(true)
      ->setDisplayOptions('form', [
        'type'   => 'text_textarea',
        'weight' => 20,
      ])
      ->setDisplayOptions('view', [
        'type'   => 'text_default',
        'label'  => 'above',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', true)
      ->setDisplayConfigurable('view', true);

    if (isset($fields['status'])) {
      $fields['status']
        ->setDisplayOptions('form', [
          'type'     => 'boolean_checkbox',
          'settings' => [
            'display_label' => true,
          ],
          'weight' => 50,
        ])
        ->setDisplayConfigurable('form', true);
    }

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created')->render())
      ->setDescription(t('The time that the changelog item was created.')->render())
      ->setTranslatable(true);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed')->render())
      ->setDescription(t('The time that the changelog item was last edited.')->render())
      ->setTranslatable(true);

    return $fields;
  }

  public function getRelease(): string
  {
    return $this->get('release')->value;
  }

  public function setRelease(string $release):self
  {
    $this->set('release', $release);

    return $this;
  }

  public function getContent(): string
  {
    return $this->get('content')->value;
  }

  public function setContent(string $content): self
  {
    $this->set('content', $content);

    return $this;
  }

  public function getCreatedTime(): int
  {
    return (int) $this->get('created')->value;
  }

  public function setCreatedTime(int $timestamp): self
  {
    $this->set('created', $timestamp);

    return $this;
  }

  public function getStatus(): bool
  {
    return (bool) $this->get('status')->value;
  }

  public function setStatus(bool $status): self
  {
    $this->set('status', $status);

    return $this;
  }

}
