<?php

declare(strict_types=1);

namespace Drupal\Tests\form\Unit;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\form\Form\Admin\NewsletterForm;
use Drupal\Tests\Core\Form\FormTestBase;

/**
 * @group form
 * @coversDefaultClass \Drupal\form\Form\Admin\NewsletterForm
 */
class NewsletterFormTest extends FormTestBase
{
  use StringTranslationTrait;

  private ImmutableConfig $config;

  private ConfigFactoryInterface $configFactory;

  private TypedConfigManagerInterface $typedConfigManager;

  private NewsletterForm $form;

  public function setUp(): void
  {
    parent::setUp();

    $this->config = $this->getMockBuilder('\Drupal\Core\Config\ImmutableConfig')
      ->disableOriginalConstructor()
      ->getMock();

    $this->configFactory = $this->getMockBuilder('Drupal\Core\Config\ConfigFactoryInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $this->configFactory
      ->expects($this->any())
      ->method('getEditable')
      ->with('newsletter.settings')
      ->will($this->returnValue($this->config));

    $this->typedConfigManager = $this->getMockBuilder('Drupal\Core\Config\TypedConfigManagerInterface')
      ->disableOriginalConstructor()
      ->getMock();

    $stringTranslation = $this->getMockBuilder('Drupal\Core\StringTranslation\TranslationInterface')
      ->disableOriginalConstructor()
      ->getMock();

    $container = new ContainerBuilder();
    $container->set('config.factory', $this->configFactory);
    $container->set('typed_config.manager', $this->typedConfigManager);
    $container->set('string_translation', $stringTranslation);
    \Drupal::setContainer($container);

    $this->form = new NewsletterForm($this->configFactory, $this->typedConfigManager);
  }

  public function testFormId(): void
  {
    $this->assertEquals('newsletter_settings', $this->form->getFormId());
  }

  public function testFormValidationCorrect(): void
  {
    $form = $this->formBuilder->getForm($this->form);

    $form_state = new FormState();
    $form_state->setValue('email', 'test@example.com');
    $form_state->setValue('color', '#ffffff');

    $this->form->validateForm($form, $form_state);

    $errors = $form_state->getErrors();

    $this->assertCount(0, $errors);
  }

  /**
   * @dataProvider fakeFormValues
   */
  public function testFormValidationIncorrect(string $email, string $color, string $field_name, string $expected_error): void
  {
    $form = $this->formBuilder->getForm($this->form);

    $form_state = new FormState();
    $form_state->setValue('email', $email);
    $form_state->setValue('color', $color);

    $this->form->validateForm($form, $form_state);

    $errors = $form_state->getErrors();

    $this->assertCount(1, $errors);
    $this->assertArrayHasKey($field_name, $errors);
    $this->assertEquals($this->t($expected_error)->render(), $errors[$field_name]);
  }

  public static function fakeFormValues(): \Generator
  {
    yield 'Email is empty' => [
      'email' => '',
      'color' => '#ffffff',
      'field_name' => 'email',
      'expected_error' => 'The email address is not valid.',
    ];

    yield 'Email is not valid' => [
      'email' => 'test.com',
      'color' => '#ffffff',
      'field_name' => 'email',
      'expected_error' => 'The email address is not valid.',
    ];

    yield 'Email is a disposable' => [
      'email' => 'test@yopmail.com',
      'color' => '#ffffff',
      'field_name' => 'email',
      'expected_error' => 'Disposable email addresses are not allowed.',
    ];

    yield 'Color is empty' => [
      'email' => 'test@example.com',
      'color' => '',
      'field_name' => 'color',
      'expected_error' => 'The color must be in hexadecimal format, starting with #.',
    ];

    yield 'Color is not stated by #' => [
      'email' => 'test@example.com',
      'color' => 'ffffff',
      'field_name' => 'color',
      'expected_error' => 'The color must be in hexadecimal format, starting with #.',
    ];

    yield 'Color is not valid' => [
      'email' => 'test@example.com',
      'color' => '#ff',
      'field_name' => 'color',
      'expected_error' => 'The color must be in hexadecimal format, starting with #.',
    ];
  }
}
