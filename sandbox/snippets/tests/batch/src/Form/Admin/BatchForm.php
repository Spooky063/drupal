<?php

declare(strict_types=1);

namespace Drupal\batch\Form\Admin;

use Drupal\batch\BatchProcessor;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
final class BatchForm extends FormBase
{
    public function __construct(
        private BatchProcessor $batchProcessor,
    ) {
    }

    public static function create(
        ContainerInterface $container,
    ): self {
        return new self(
            $container->get('batch.processor')
        );
    }

    public function getFormId(): string
    {
        return 'batch_form';
    }

    /**
     * @return array<array-key, mixed>
     */
    public function buildForm(
        array $form,
        FormStateInterface $form_state
    ): array {
        $form['help'] = [
        '#markup' => $this->t('Submit this form to run batch operation.'),
        ];

        $form['actions'] = [
        '#type' => 'actions',
        ];

        $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Run batch'),
        ];

        return $form;
    }

    public function submitForm(
        array &$form,
        FormStateInterface $form_state
    ): void {
        $items = array_chunk(range(1, 100), 10);

        $this->batchProcessor->execute($items);

        $form_state->setRedirectUrl(new Url('form.batch'));
    }
}
