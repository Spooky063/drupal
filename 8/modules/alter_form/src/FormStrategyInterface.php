<?php

declare(strict_types=1);

namespace Drupal\alter_form;

interface FormStrategyInterface
{
  public function alter(array &$form): void;
}
