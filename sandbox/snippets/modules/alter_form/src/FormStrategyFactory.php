<?php

declare(strict_types=1);

namespace Drupal\alter_form;

use Drupal\alter_form\Strategy\UserEditFormStrategy;
use Drupal\alter_form\Strategy\UserLoginFormStrategy;

final class FormStrategyFactory
{
  public function create(string $form_id): ?FormStrategyInterface
  {
    return match($form_id) {
      'user_form' => new UserEditFormStrategy(),
      'user_login_form' => new UserLoginFormStrategy(),
      default => null,
    };
  }
}
