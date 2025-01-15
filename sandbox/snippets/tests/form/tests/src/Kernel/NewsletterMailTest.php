<?php

declare(strict_types=1);

namespace Drupal\Tests\form\Kernel;

use Drupal\Core\Form\FormState;
use Drupal\Core\Test\AssertMailTrait;
use Drupal\KernelTests\KernelTestBase;

/**
 * @group form
 */
class NewsletterMailTest extends KernelTestBase
{
  use AssertMailTrait;

  protected static $modules = [
    'user',
    'system',
    'form'
  ];

  public function testSendingNewsletterEmail(): void
  {
    $this->config('system.site')->set('mail', 'site@example.com')->save();

    $to = 'test@example.com';
    \Drupal::moduleHandler()->invoke('form', 'send_newsletter_email', [$to]);

    $emails = $this->getMails();
    $this->assertCount(1, $emails);

    $email = reset($emails);
    $this->assertEquals('site@example.com', $email['from']);
    $this->assertEquals($to, $email['to']);
    $this->assertEquals('Newsletter', $email['subject']);
    $this->assertStringContainsString('This is the newsletter message.', $email['body']);
  }

  public function testNewsletterSubmissionSendingEmail(): void
  {
    $form_state = new FormState();
    $to = 'test@example.com';
    $form_state->setValue('email', $to);

    $form_class = \Drupal::classResolver()->getInstanceFromDefinition('Drupal\form\Form\Admin\NewsletterForm');
    $form = [];
    $form_class->submitForm($form, $form_state);

    $emails = $this->getMails();
    $this->assertCount(1, $emails);

    $email = reset($emails);
    $this->assertEquals($to, $email['to']);
  }
}
