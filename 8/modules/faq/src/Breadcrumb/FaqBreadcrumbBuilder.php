<?php

declare(strict_types=1);

namespace Drupal\faq\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Controller\TitleResolverInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class FaqBreadcrumbBuilder implements BreadcrumbBuilderInterface
{
    protected ?Request $request;

    protected RouterInterface $router;

    protected EntityRepositoryInterface $entityRepository;

    protected EntityTypeManagerInterface $entityTypeManager;

    protected TitleResolverInterface $titleResolver;

    public function __construct(
        RequestStack $request,
        RouterInterface $router,
        EntityRepositoryInterface $entityRepository,
        EntityTypeManagerInterface $entityTypeManager,
        TitleResolverInterface $titleResolver
    ) {
        $this->request = $request->getCurrentRequest();
        $this->router = $router;
        $this->entityRepository = $entityRepository;
        $this->entityTypeManager = $entityTypeManager;
        $this->titleResolver = $titleResolver;
    }

    public function applies(RouteMatchInterface $route_match): bool
    {
        $parameters = $route_match->getParameters()->all();
        $routeName = $route_match->getRouteName();

        if ($routeName === 'entity.taxonomy_term.canonical' && $parameters['taxonomy_term']->bundle() === 'faq') {
            return true;
        }
        if ($routeName === 'faq.page') {
            return true;
        }

        return false;
    }

    public function build(RouteMatchInterface $route_match): Breadcrumb
    {
        $breadcrumb = new Breadcrumb();

        $breadcrumb->addCacheContexts(['url']);

        $breadcrumb->addLink(Link::createFromRoute((string) t('Home'), '<front>'));

        if ($this->request !== null) {
            $route = $route_match->getRouteObject();
            /** @var string $faqTitle */
            $faqTitle = Url::fromRoute('faq.page')->toString();
            $faqRouteInfo = $this->router->match($faqTitle);
            /** @var Route $faqRoute */
            $faqRoute = $faqRouteInfo['_route_object'];
            if ($route !== null) {
                if ($route->getPath() === $faqRoute->getPath()) {
                    $page_title = $this->titleResolver->getTitle($this->request, $route);
                    if ($page_title !== null && !empty($page_title)) {
                        /** @var string $title */
                        $title = $page_title;
                        $breadcrumb->addLink(Link::createFromRoute($title, '<none>'));
                    }
                } else {
                    $page_title = $this->titleResolver->getTitle($this->request, $faqRoute);
                    if ($page_title !== null && !empty($page_title)) {
                        /** @var string $title */
                        $title = $page_title;
                        $breadcrumb->addLink(Link::createFromRoute($title, 'faq.page'));
                    }

                    $term = $route_match->getParameter('taxonomy_term');
                    $breadcrumb->addCacheableDependency($term);
                    /** @var TermStorageInterface $termStorage */
                    $termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
                    $parents = $termStorage->loadAllParents($term->id());
                    $parents = array_reverse($parents);
                    foreach ($parents as $index => $term) {
                        /** @var TermInterface $term */
                        $term = $this->entityRepository->getTranslationFromContext($term);
                        $breadcrumb->addCacheableDependency($term);
                        if ($index === \array_key_last($parents)) {
                            $breadcrumb->addLink(Link::createFromRoute($term->getName(), '<none>'));
                        } else {
                            $breadcrumb->addLink(Link::createFromRoute(
                                $term->getName(),
                                'entity.taxonomy_term.canonical',
                                ['taxonomy_term' => $term->id()]
                            ));
                        }
                    }
                    $breadcrumb->addCacheContexts(['route']);
                }
            }
        }

        return $breadcrumb;
    }
}
