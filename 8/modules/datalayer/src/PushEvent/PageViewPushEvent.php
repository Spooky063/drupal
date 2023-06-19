<?php

declare(strict_types=1);

namespace Drupal\datalayer\PushEvent;

use Drupal\datalayer\DataLayer\DataLayerPushRenderable;

final class PageViewPushEvent implements DataLayerPushRenderable
{
    public function render(): array
    {
        return [
            'event' =>  'Pageview',
            // To filled
            'pagePath' => '',
            'pageTitle' => '',
            'visitorType' =>  ''
        ];
    }
}
