<?php

declare(strict_types=1);

namespace Drupal\faq\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class FaqForm extends ContentEntityForm
{
    public function save(array $form, FormStateInterface $form_state)
    {
        $entity = $this->getEntity();
        $result = $entity->save();
        $message_arguments = ['%label' => $this->entity->label()];

        if ($result === SAVED_NEW) {
            $this->messenger()->addStatus($this->t('New faq %label has been created.', $message_arguments));
            $this->logger('faq')->notice('Created new faq %label', $message_arguments);
        } else {
            $this->messenger()->addStatus($this->t('The faq %label has been updated.', $message_arguments));
            $this->logger('faq')->notice('Updated new faq %label.', $message_arguments);
        }
    }
}
