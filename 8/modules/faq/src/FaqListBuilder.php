<?php

declare(strict_types=1);

namespace Drupal\faq;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FaqListBuilder extends EntityListBuilder
{
    protected DateFormatterInterface $dateFormatter;

    protected LanguageManagerInterface $languageManager;

    protected RendererInterface $renderer;

    public function __construct(
        EntityTypeInterface $entity_type,
        EntityStorageInterface $storage,
        DateFormatterInterface $date_formatter,
        LanguageManagerInterface $languageManager,
        RendererInterface $renderer
    ) {
        parent::__construct($entity_type, $storage);
        $this->dateFormatter = $date_formatter;
        $this->languageManager = $languageManager;
        $this->renderer = $renderer;
    }

    public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type): self
    {
        return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter'),
      $container->get('language_manager'),
      $container->get('renderer')
    );
    }

    public function buildHeader(): array
    {
        $header = [
            'question' => $this->t('Question'),
            'category' => [
                'data'  => $this->t('Category'),
                'class' => [RESPONSIVE_PRIORITY_MEDIUM],
            ],
            'author'   => [
                'data'  => $this->t('Author'),
                'class' => [RESPONSIVE_PRIORITY_LOW],
            ],
            'status'  => $this->t('Status'),
            'changed' => [
                'data'  => $this->t('Updated'),
                'class' => [RESPONSIVE_PRIORITY_LOW],
            ],
        ];
        if ($this->languageManager->isMultilingual()) {
            $header['language_name'] = [
                'data'  => $this->t('Language'),
                'class' => [RESPONSIVE_PRIORITY_LOW],
            ];
        }

        return $header + parent::buildHeader();
    }

    public function buildRow(EntityInterface $entity): array
    {
        /** @var FaqInterface $entity */
        $entity = $entity;
        $mark = [
            '#theme'     => 'mark',
            '#mark_type' => node_mark((int) $entity->id(), $entity->getChangedTime()),
        ];
        $languages = $this->languageManager->getLanguages();
        $langcode = $entity->language()->getId();
        $uri = $entity->toUrl();
        $options = $uri->getOptions();
        $options += $langcode !== LanguageInterface::LANGCODE_NOT_SPECIFIED && isset($languages[$langcode]) ?
            ['language' => $languages[$langcode]] :
            [];
        $uri->setOptions($options);
        $row['question']['data'] = [
            '#type'   => 'link',
            '#title'  => $entity->label(),
            '#suffix' => ' ' . $this->renderer->render($mark),
            '#url'    => $uri,
        ];
        $row['category'] = $entity->getCategory() !== null ? $entity->getCategory()->getName() : '';
        $row['author']['data'] = [
            '#theme'   => 'username',
            '#account' => $entity->getOwner(),
        ];
        $row['status'] = $entity->isPublished() ? $this->t('published') : $this->t('not published');
        $row['changed'] = $this->dateFormatter->format($entity->getChangedTime(), 'short');
        if ($this->languageManager->isMultilingual()) {
            $row['language_name'] = $this->languageManager->getLanguageName($langcode);
        }
        $row['operations']['data'] = $this->buildOperations($entity);

        return $row + parent::buildRow($entity);
    }
}
