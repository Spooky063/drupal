<?php

declare(strict_types=1);

namespace Drupal\alter_form\Strategy;

use Drupal\alter_form\FormStrategyInterface;

final class UserEditFormStrategy implements FormStrategyInterface
{
  public function alter(array &$form): void
  {
    $form['actions']['submit']['#submit'][] = [ActionUserEditDataLayer::class, 'addElement'];
  }
}
