<?php

declare(strict_types=1);

namespace Drupal\faq\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\faq\FaqInterface;
use Drupal\faq\FaqService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FaqController extends ControllerBase implements ContainerInjectionInterface
{
    const LIMIT = 10;

    protected FaqService $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public static function create(ContainerInterface $container): self
    {
        return new static(
          $container->get('faq.service')
        );
    }

    public function index(Request $request): array
    {
        $search = $request->get('search');
        if ($search !== null) {
            /** @var FaqInterface[] $faqEntities */
            $faqEntities = $this->faqService->getFaqByQuestion($search, self::LIMIT);
        } else {
            /** @var FaqInterface[] $faqEntities */
            $faqEntities = $this->faqService->getTopFaq();
        }

        $faqCategories = $this->faqService->getFaqVocabularyTaxonomyTermTree();

        $faqs = [];
        foreach ($faqEntities as $key => $faqEntity) {
            $faqs[$key] = $this->faqService->renderFaqElement($faqEntity);
        }

        $build = [
            '#theme'      => 'faq_page',
            '#faqs'       => $faqs,
            '#categories' => $faqCategories,
            '#search'     => $search,
            '#pager'      => [
                '#type' => 'pager',
            ],
            '#cache' => [
                'contexts' => [
                    'url.path',
                    'url.query_args'
                ],
            ]
        ];
        $build['#attached']['library'][] = 'faq/accordion';

        return $build;
    }
}
