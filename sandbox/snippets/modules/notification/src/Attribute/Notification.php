<?php

declare(strict_types=1);

namespace Drupal\notification\Attribute;

use Drupal\Component\Plugin\Attribute\AttributeBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class Notification extends AttributeBase
{
    public function __construct(
        public readonly string $id,
        public readonly ?TranslatableMarkup $label,
        public readonly ?TranslatableMarkup $description = null,
        public readonly ?string $deriver = null,
    ) {
    }
}
