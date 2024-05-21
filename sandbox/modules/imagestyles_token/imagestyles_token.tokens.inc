<?php

declare(strict_types=1);

/**
 * @file
 * Image styles token integration.
 */

use Drupal\Core\Render\BubbleableMetadata;
use Drupal\image\Entity\ImageStyle;

function getImageStyles(): array
{
    $data = [];

    /** @var ImageStyle[] $styles */
    $styles = ImageStyle::loadMultiple();

    foreach ($styles as $style) {
        $nameEffects = [];
        $effects = $style->getEffects();
        foreach ($effects as $effect) {
            $configuration = $effect->getConfiguration()['data'];
            if (count($configuration) !== 0) {
                $nameEffects[] = t(
                    '@effect (@width * @height@anchor)',
                    [
                        '@effect' => $effect->label(),
                        '@width' => $configuration['width'],
                        '@height' => $configuration['height'],
                        '@anchor' => isset($configuration['anchor']) ? ' / ' . t('position') . ': ' . $configuration['anchor'] : ''
                    ]
                );
            } else {
                $nameEffects[] = t('@effect', ['@effect' => $effect->label()]);
            }
        }

        $data[$style->getName()] = [
            'label' => $style->label(),
            'effects' => $nameEffects,
        ];
    }

    return $data;
}

function imagestyles_token_token_info(): array
{
    $imageStyles = getImageStyles();
    $types = $imageStylesTokens = $imageStyleTokens = [];

    $types['image-styles'] = [
        'name' => t('Image styles'),
        'description' => t('Tokens related to image styles.'),
        'needs-data' => 'image-styles',
    ];

    foreach ($imageStyles as $machineName => $style) {
        $imageStylesTokens[$machineName] = [
            'name' => $style['label']
        ];
    }

    $types['image-style'] = [
        'name' => t('Image style'),
        'description' => t('Tokens related to image styles.'),
    ];

    $imageStyleTokens['machine-name'] = [
        'name' => t('Machine name'),
        'description' => t('The machine name of image style.'),
        'type' => 'image-styles',
    ];

    $imageStyleTokens['label'] = [
        'name' => t('Label'),
        'description' => t('The name of image style.'),
        'type' => 'image-styles',
    ];

    $imageStyleTokens['effects'] = [
        'name' => t('Effects'),
        'description' => t('Effects apply to image style.'),
        'type' => 'image-styles',
    ];

    return [
        'types' => $types,
        'tokens' => [
            'image-styles' => $imageStylesTokens,
            'image-style' => $imageStyleTokens
        ]
    ];
}

function imagestyles_token_tokens(string $type, array $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata): array
{
    $replacements = [];
    $token_service = \Drupal::token();
    $renderer = \Drupal::service('renderer');
    $imageStyles = getImageStyles();

    $machineNameTokens = $token_service->findWithPrefix($tokens, 'machine-name');
    foreach ($machineNameTokens as $name => $original) {
        $replacements[$original] = $name;
    }

    $labelTokens = $token_service->findWithPrefix($tokens, 'label');
    foreach ($labelTokens as $name => $original) {
        $replacements[$original] = $imageStyles[$name]['label'];
    }

    $effectsTokens = $token_service->findWithPrefix($tokens, 'effects');
    foreach ($effectsTokens as $name => $original) {
        $effect = [
            '#theme' => 'item_list',
            '#type' => 'ul',
            '#items' => $imageStyles[$name]['effects']
        ];
        $replacements[$original] = $renderer->render($effect);
    }

    return $replacements;
}
