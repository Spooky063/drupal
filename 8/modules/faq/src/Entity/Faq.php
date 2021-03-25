<?php

declare(strict_types=1);

namespace Drupal\faq\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\EntityReferenceFieldItemListInterface;
use Drupal\faq\FaqInterface;
use Drupal\taxonomy\TermInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the faq entity class.
 *
 * @ContentEntityType(
 *   id = "faq",
 *   label = @Translation("Faq"),
 *   label_collection = @Translation("Faqs"),
 *   label_singular = @Translation("faq item"),
 *   label_plural = @Translation("faq items"),
 *   label_count = @PluralTranslation(
 *     singular = "@count faq item",
 *     plural = "@count faq items"
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\faq\FaqListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\faq\FaqAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\faq\Form\FaqForm",
 *       "edit" = "Drupal\faq\Form\FaqForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "faq",
 *   data_table = "faq_field_data",
 *   translatable = TRUE,
 *   admin_permission = "access faq overview",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "question",
 *     "uuid" = "uuid",
 *     "published" = "status",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "add-form" = "/admin/content/faq/add",
 *     "canonical" = "/faq/{faq}",
 *     "edit-form" = "/admin/content/faq/{faq}/edit",
 *     "delete-form" = "/admin/content/faq/{faq}/delete",
 *     "collection" = "/admin/content/faq"
 *   },
 * )
 */
class Faq extends ContentEntityBase implements FaqInterface
{
    use EntityChangedTrait;
    use EntityOwnerTrait;
    use EntityPublishedTrait;

    public static function preCreate(EntityStorageInterface $storage_controller, array &$values): void
    {
        parent::preCreate($storage_controller, $values);
        $values += ['uid' => \Drupal::currentUser()->id()];
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        /** @var FieldDefinitionInterface $fields */
        $fields = parent::baseFieldDefinitions($entity_type);
        $fields += static::publishedBaseFieldDefinitions($entity_type);
        $fields += static::ownerBaseFieldDefinitions($entity_type);

        $fields['question'] = BaseFieldDefinition::create('string')
            ->setTranslatable(true)
            ->setLabel((string) t('Question'))
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

        $fields['answer'] = BaseFieldDefinition::create('text_long')
            ->setTranslatable(true)
            ->setLabel((string) t('Answer'))
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

        $fields['category'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel((string) t('Category'))
            ->setRequired(false)
            ->setSetting('target_type', 'taxonomy_term')
            ->setSetting('handler', 'default:taxonomy_term')
            ->setSetting('handler_settings', [
                'target_bundles' => [
                    'faq' => 'faq'
                ]
            ])
            ->setDisplayOptions('view', [
                'label'  => 'hidden',
                'type'   => 'author',
                'weight' => 0,
            ])
            ->setDisplayOptions('form', [
                'type'     => 'entity_reference_autocomplete',
                'label'    => 'above',
                'weight'   => 10,
                'settings' => [
                    'match_operator'    => 'CONTAINS',
                    'size'              => '60',
                    'placeholder'       => '',
                ],
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
            ->setLabel((string) t('Created'))
            ->setDescription((string) t('The time that the faq was created.'))
            ->setTranslatable(true);

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel((string) t('Changed'))
            ->setDescription((string) t('The time that the faq was last edited.'))
            ->setTranslatable(true);

        $fields['top'] = BaseFieldDefinition::create('boolean')
            ->setLabel((string) t('Top Frequently Asked Questions?'))
            ->setTranslatable(true)
            ->setDefaultValue(true)
            ->setDisplayOptions('form', [
                'type'     => 'boolean_checkbox',
                'settings' => [
                    'display_label' => true,
                ],
                'weight' => 15,
            ])
            ->setDisplayConfigurable('form', true);

        return $fields;
    }

    public function getQuestion(): string
    {
        return $this->get('question')->value;
    }

    public function setQuestion(string $question): self
    {
        $this->set('question', $question);

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->get('answer')->value;
    }

    public function setAnswer(string $answer): self
    {
        $this->set('answer', $answer);

        return $this;
    }

    public function getCategory(): ?TermInterface
    {
        /** @var EntityReferenceFieldItemListInterface $entityField */
        $entityField = $this->get('category');
        $entities = $entityField->referencedEntities();
        if (\count($entities) > 0) {
            /** @var TermInterface $entity */
            $entity = \reset($entities);

            return $entity;
        }

        return null;
    }

    public function setCategory($category): self
    {
        $this->set('category', $category);

        return $this;
    }

    public function getTop(): bool
    {
        return (bool) $this->get('top')->value;
    }

    public function setTop(bool $top): self
    {
        $this->set('top', $top);

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
