<?php

declare(strict_types=1);

namespace Drupal\alter_form\Strategy;

use Drupal\alter_form\FormStrategyInterface;

final class UserLoginFormStrategy implements FormStrategyInterface
{
  public function alter(array &$form): void
  {
    $form['#submit'][] = [ActionUserLoginDataLayer::class, 'addElement'];
  }
}
