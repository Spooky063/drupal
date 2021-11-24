# Page attachment alter

1. Add pager attribute on `head` tag

```php
function THEME_page_attachments_alter(array &$attachments)
{
    global $pager_total, $pager_page_array;

    $route = \Drupal::routeMatch()->getRouteObject();
    $is_admin = \Drupal::service('router.admin_context')->isAdminRoute($route);
    if ($is_admin) {
        return;
    }

    if ($pager_total === NULL && $pager_page_array === NULL) {
        return;
    }

    $query_string = \Drupal::request()->getQueryString();
    $query = array();
    if (!empty($query_string)) {
        parse_str($query_string, $query);
    }
    $prev = $next = $query;

    if ($pager_page_array[0] <= 1) {
        unset($prev['page']);
    }
    else {
        $prev['page'] = $page = $pager_page_array[0] - 1;
    }

    if ($pager_page_array[0] >= $pager_total[0] - 1) {
        unset($next['page']);
    }
    else {
        $next['page'] = $page = $pager_page_array[0] + 1;
    }

    if ($pager_page_array[0] > 0) {
        $attachments['#attached']['html_head'][] = [[
            '#type' => 'html_tag',
            '#tag' => 'link',
            '#attributes' => [
                'rel' => 'prev',
                'href' => \Drupal\Core\Url::fromRoute(
                    \Drupal::routeMatch()->getRouteName(),
                    \Drupal::routeMatch()->getParameters()->all(),
                    [
                        'query' => $prev,
                        'absolute' => TRUE
                    ]
                )->toString(),
            ],
        ], 'rel_prev'];

        $key = array_search("canonical_url", array_column($attachments['#attached']['html_head'], '1'));
        $url_options = ['absolute' => TRUE, 'query' => ['page' => $page-1]]; // Because start at 0
        $url = Drupal\Core\Url::fromRoute('<current>', [], $url_options)->toString();
        $attachments['#attached']['html_head'][$key][0]['#attributes']['href'] = $url;
    }

    if (isset($next['page'])) {
        $attachments['#attached']['html_head'][] = [[
            '#type' => 'html_tag',
            '#tag' => 'link',
            '#attributes' => [
                'rel' => 'next',
                'href' => \Drupal\Core\Url::fromRoute(
                    \Drupal::routeMatch()->getRouteName(),
                    \Drupal::routeMatch()->getParameters()->all(),
                    [
                        'query' => $next,
                        'absolute' => TRUE
                    ]
                )->toString(),
            ],
        ], 'rel_next'];
    }
}
```