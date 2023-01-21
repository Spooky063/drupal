<?php

declare(strict_types=1);

namespace Drupal\changelog\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class ChangelogForm extends ContentEntityForm
{
  public function save(
    array $form,
    FormStateInterface $form_state
  ): void
  {
    $result = $this->getEntity()->save();
    $message_arguments = ['%label' => $this->entity->label()];

    if ($result === SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New changelog %label has been created.', $message_arguments));
      $this->logger('faq')->notice('Created new changelog %label', $message_arguments);
    } else {
      $this->messenger()->addStatus($this->t('The changelog %label has been updated.', $message_arguments));
      $this->logger('faq')->notice('Updated new changelog %label.', $message_arguments);
    }

    $form_state->setRedirect('entity.changelog.collection');
  }
}
