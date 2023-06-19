<?php

declare(strict_types=1);

namespace Drupal\datalayer\Action;

use Drupal\Core\Form\FormStateInterface;
use Drupal\datalayer\DataLayer\DataLayer;
use Drupal\datalayer\PushEvent\PageViewPushEvent;
use Drupal\datalayer\PushEvent\UserEditPushEvent;

final class ActionUserEditDataLayer
{
    public static function addElement(array $form, FormStateInterface $form_state): void
    {
        $values = $form_state->getValues();

        $datalayer = new DataLayer();
        $datalayer->addPush(
            (new UserEditPushEvent())
                ->setName($values['name'])
        );
        $datalayer->addPush(
            new PageViewPushEvent()
        );
    }
}
