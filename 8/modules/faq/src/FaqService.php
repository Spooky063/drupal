<?php

declare(strict_types=1);

namespace Drupal\faq;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\EntityReferenceFieldItemListInterface;
use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;

class FaqService
{
    protected EntityTypeManagerInterface $entityTypeManager;

    public function __construct(EntityTypeManagerInterface $entityTypeManager)
    {
        $this->entityTypeManager = $entityTypeManager;
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
        $children_ids = array_map(fn ($child) => $child->tid, $children);
        $term_ids = array_merge($term_ids, $children_ids);

        $faqStorage = $this->entityTypeManager->getStorage('faq');
        $query = $faqStorage->getQuery()
            ->condition('category', $term_ids, 'IN')
            ->condition('status', true);
        /** @var array $ids */
        $ids = $query->execute();

        return $faqStorage->loadMultiple($ids);
    }

    /**
     * @return object[]
     */
    public function getFaqVocabularyTaxonomyTermTree(int $parent = 0, int $depth = 1)
    {
        /** @var TermStorageInterface $termStorage */
        $termStorage = $this->entityTypeManager->getStorage('taxonomy_term');

        return $termStorage->loadTree('faq', $parent, $depth);
    }

    public function getParentTermByTerm(TermInterface $term): ?TermInterface
    {
        /** @var EntityReferenceFieldItemListInterface $parentField */
        $parentField = $term->get('parent');
        $parentEntities = $parentField->referencedEntities();
        if (\count($parentEntities) > 0) {
            /** @var TermInterface $parent */
            $parent = reset($parentEntities);

            return $parent;
        }

        return null;
    }

    public function renderFaqElement(EntityInterface $faq): array
    {
        /** @var FaqInterface $faq */
        $faq = $faq;
        $faqs['question'] = $faq->getQuestion();
        $faqs['answer'] = $faq->getAnswer();
        $category = $faq->getCategory();

        if ($category instanceof TermInterface) {
            /** @var EntityReferenceFieldItemListInterface $parentField */
            $parentField = $category->get('parent');
            $parentEntities = $parentField->referencedEntities();

            if (\count($parentEntities) === 0) {
                $faqs['category']['tid'] = $category->id();
                $faqs['category']['name'] = $category->getName();
            } else {
                /** @var TermInterface $parent */
                $parent = reset($parentEntities);
                $faqs['category']['tid'] = $parent->id();
                $faqs['category']['name'] = $parent->getName();
                $faqs['subcategory']['tid'] = $category->id();
                $faqs['subcategory']['name'] = $category->getName();
            }
        }

        return $faqs;
    }
}
