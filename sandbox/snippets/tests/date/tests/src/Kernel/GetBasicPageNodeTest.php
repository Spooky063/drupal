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
 */
class GetBasicPageNodeTest extends KernelTestBase {

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

    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('node'), 'Le module node est actif.');
    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('user'), 'Le module user est actif.');

    $this->nodes['1'] = $this->createNode(['type' => 'page', 'title' => 'Page 1', 'created' => (new \DateTime('2025-01-01'))->format('U')]);
    $this->assertNotNull($this->nodes['1'], 'Le nœud a été créé.');
    $this->assertEquals('Page 1', $this->nodes['1']->label(), 'Le titre du nœud est correct.');

    $this->nodes['2'] = $this->createNode(['type' => 'page', 'title' => 'Page 2', 'created' => (new \DateTime('2026-01-01'))->format('U')]);
    $this->assertNotNull($this->nodes['2'], 'Le nœud a été créé.');
    $this->assertEquals('Page 2', $this->nodes['2']->label(), 'Le titre du nœud est correct.');
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


  public function dateScenarios(): \Generator
  {
    yield '2025-01-01' => [
      'date' => strtotime('2025-01-01 00:00:00'),
      'expected' => ['Page 1'],
    ];

    yield '2026-01-01' => [
      'date' => strtotime('2026-01-01 00:00:00'),
      'expected' => ['Page 2', 'Page 1'],
    ];
  }
}
