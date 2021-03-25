<?php

declare(strict_types=1);

namespace Drupal\faq;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\EntityReferenceFieldItemListInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;

class FaqService
{
    protected EntityTypeManagerInterface $entityTypeManager;

    protected LanguageManagerInterface $languageManager;

    public function __construct(
        EntityTypeManagerInterface $entityTypeManager,
        LanguageManagerInterface $languageManager
    ) {
        $this->entityTypeManager = $entityTypeManager;
        $this->languageManager = $languageManager;
    }

    /**
     * @return EntityInterface[]
     */
    public function getTopFaq()
    {
        $faqStorage = $this->entityTypeManager->getStorage('faq');
        $query = $faqStorage->getQuery()
            ->condition('top', true)
            ->condition('status', true)
            ->condition('langcode', $this->languageManager->getCurrentLanguage()->getId())
            ->sort('changed', 'DESC');
        /** @var array $ids */
        $ids = $query->execute();

        return $faqStorage->loadMultiple($ids);
    }

    /**
     * @return EntityInterface[]
     */
    public function getFaqByQuestion(string $search, int $limit)
    {
        $faqStorage = $this->entityTypeManager->getStorage('faq');
        $query = $faqStorage->getQuery()
            ->condition('question', "%{$search}%", 'LIKE')
            ->condition('status', true)
            ->condition('langcode', $this->languageManager->getCurrentLanguage()->getId())
            ->pager($limit);
        /** @var array $ids */
        $ids = $query->execute();

        return $faqStorage->loadMultiple($ids);
    }

    /**
     * @return EntityInterface[]
     */
    public function getFaqByTaxonomyTerm(TermInterface $term)
    {
        $term_ids = [$term->id()];
        $children = $this->getFaqVocabularyTaxonomyTermTree((int) $term->id());
        $children_ids = array_map(fn ($child) => $child->id(), $children);
        $term_ids = array_merge($term_ids, $children_ids);

        $faqStorage = $this->entityTypeManager->getStorage('faq');
        $query = $faqStorage->getQuery()
            ->condition('category', $term_ids, 'IN')
            ->condition('status', true)
            ->condition('langcode', $this->languageManager->getCurrentLanguage()->getId());
        /** @var array $ids */
        $ids = $query->execute();

        return $faqStorage->loadMultiple($ids);
    }

    /**
     * @return TermInterface[]
     */
    public function getFaqVocabularyTaxonomyTermTree(int $parent = 0, int $depth = 1)
    {
        /** @var TermStorageInterface $termStorage */
        $termStorage = $this->entityTypeManager->getStorage('taxonomy_term');

        $terms = $termStorage->loadTree('faq', $parent, $depth, true);
        $terms = \array_map(function ($term) {
            if ($term->hasTranslation($this->languageManager->getCurrentLanguage()->getId())) {
                return $term->getTranslation($this->languageManager->getCurrentLanguage()->getId());
            }
        }, $terms);

        return $terms;
    }

    public function getParentTermByTerm(TermInterface $term): ?TermInterface
    {
        /** @var EntityReferenceFieldItemListInterface $parentField */
        $parentField = $term->get('parent');
        $parentEntities = $parentField->referencedEntities();
        if (\count($parentEntities) > 0) {
            /** @var TermInterface $parent */
            $parent = reset($parentEntities);

            if ($parent->hasTranslation($this->languageManager->getCurrentLanguage()->getId())) {
                $parent = $parent->getTranslation($this->languageManager->getCurrentLanguage()->getId());
            }

            return $parent;
        }

        return null;
    }

    public function renderFaqElement(EntityInterface $faq): array
    {
        /** @var FaqInterface $faq */
        $faq = $faq;
        if ($faq->hasTranslation($this->languageManager->getCurrentLanguage()->getId())) {
            $faq = $faq->getTranslation($this->languageManager->getCurrentLanguage()->getId());
        }
        $faqs['question'] = $faq->getQuestion();
        $faqs['answer'] = $faq->getAnswer();
        $category = $faq->getCategory();

        if ($category instanceof TermInterface) {
            if ($category->hasTranslation($this->languageManager->getCurrentLanguage()->getId())) {
                $category = $category->getTranslation($this->languageManager->getCurrentLanguage()->getId());
            }

            /** @var EntityReferenceFieldItemListInterface $parentField */
            $parentField = $category->get('parent');
            $parentEntities = $parentField->referencedEntities();

            if (\count($parentEntities) === 0) {
                $faqs['category']['tid'] = $category->id();
                $faqs['category']['name'] = $category->getName();
            } else {
                /** @var TermInterface $parent */
                $parent = reset($parentEntities);
                if ($parent->hasTranslation($this->languageManager->getCurrentLanguage()->getId())) {
                    $parent = $parent->getTranslation($this->languageManager->getCurrentLanguage()->getId());
                }

                $faqs['category']['tid'] = $parent->id();
                $faqs['category']['name'] = $parent->getName();
                $faqs['subcategory']['tid'] = $category->id();
                $faqs['subcategory']['name'] = $category->getName();
            }
        }

        return $faqs;
    }

    public function renderFaqCategory(TermInterface $term): array
    {
        return [
            'tid'  => $term->id(),
            'name' => $term->getName(),
        ];
    }
}
