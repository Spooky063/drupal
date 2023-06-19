<?php

declare(strict_types=1);

namespace Drupal\datalayer\DataLayer;

final class DataLayer
{
    public function addPush(DataLayerPushRenderable $push): void
    {
        $rendered = $push->render();

        $session = \Drupal::request()->getSession();
        if ($dl = $session->get('dataLayer')) {
            $rendered = [$dl, $rendered];
        }

        $session->set('dataLayer', $rendered);
    }

    public static function getPushes(): ?array
    {
        $session = \Drupal::request()->getSession();
        $dl = $session->get('dataLayer');
        $session->remove('dataLayer');

        return $dl;
    }
}
