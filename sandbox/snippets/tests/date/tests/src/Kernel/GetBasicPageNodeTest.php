<?php

declare(strict_types = 1);

namespace Drupal\Tests\date\Kernel;

use Drupal\date\Action\GetBasicPageNode;
use Drupal\date\ValueObect\DateValue;
use Drupal\KernelTests\KernelTestBase;
use Drupal\node\NodeInterface;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * @group date
 * @coversDefaultClass \Drupal\date\Action\GetBasicPageNode
 */
class GetBasicPageNodeTest extends KernelTestBase
{
  use NodeCreationTrait;

  /** @var NodeInterface[] */
  protected $nodes = [];

  protected static $modules = [
    'node',
    'user',
    'system',
  ];

  protected function setUp(): void
  {
    parent::setUp();

    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installSchema('node', ['node_access']);

    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('node'));
    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('user'));

    $this->nodes['1'] = $this->createNode(['type' => 'page', 'title' => 'Page 1', 'created' => (new \DateTime('2025-01-01'))->format('U')]);
    $this->assertNotNull($this->nodes['1']);
    $this->assertEquals('Page 1', $this->nodes['1']->label());

    $this->nodes['2'] = $this->createNode(['type' => 'page', 'title' => 'Page 2', 'created' => (new \DateTime('2026-01-01'))->format('U')]);
    $this->assertNotNull($this->nodes['2']);
    $this->assertEquals('Page 2', $this->nodes['2']->label());
  }

  public function testWithDateFrom2024(): void
  {
    $dateProvider = new DateValue(strtotime('2024-01-01 00:00:00'));
    $entityTypeManager = $this->container->get('entity_type.manager');

    $action = new GetBasicPageNode($entityTypeManager, $dateProvider);
    $result = $action->execute();

    $this->assertCount(0, $result);
  }

  public function testWithDateFrom2025(): void
  {
    $dateProvider = new DateValue(strtotime('2025-01-01 00:00:00'));
    $entityTypeManager = $this->container->get('entity_type.manager');

    $action = new GetBasicPageNode($entityTypeManager, $dateProvider);
    $result = $action->execute();

    $this->assertCount(1, $result);
    $this->assertEquals($this->nodes['1']->label(), $result[0]->label());
  }

  public function testWithDateFrom2026(): void
  {
    $dateProvider = new DateValue(strtotime('2026-01-01 00:00:00'));
    $entityTypeManager = $this->container->get('entity_type.manager');

    $action = new GetBasicPageNode($entityTypeManager, $dateProvider);
    $result = $action->execute();

    $this->assertCount(2, $result);
    $this->assertEquals($this->nodes['2']->label(), $result[0]->label());
    $this->assertEquals($this->nodes['1']->label(), $result[1]->label());
  }

  /**
   * @dataProvider dateScenarios
   */
  public function testWithDateScenarios(int $date, array $expected_labels): void
  {
    $dateProvider = new DateValue($date);
    $entityTypeManager = $this->container->get('entity_type.manager');

    $action = new GetBasicPageNode($entityTypeManager, $dateProvider);
    $result = $action->execute();

    $this->assertCount(count($expected_labels), $result);
    foreach ($expected_labels as $index => $label) {
        $this->assertEquals($label, $result[$index]->label(), "Le résultat $index est incorrect.");
    }
  }

  public static function dateScenarios(): \Generator
  {
    yield '2025-01-01' => [
      'date' => strtotime('2025-01-01 00:00:00'),
      'expected_labels' => ['Page 1'],
    ];

    yield '2026-01-01' => [
      'date' => strtotime('2026-01-01 00:00:00'),
      'expected_labels' => ['Page 2', 'Page 1'],
    ];
  }
}
