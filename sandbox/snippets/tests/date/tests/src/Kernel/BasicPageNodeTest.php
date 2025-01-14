<?php

declare(strict_types = 1);

namespace Drupal\Tests\date\Unit;

use Drupal\date\Entity\BasicPageNode;
use Drupal\node\NodeInterface;
use Drupal\Tests\node\Kernel\NodeAccessTestBase;

/**
 * @group date
 * @coversDefaultClass \Drupal\date\Entity\BasicPageNode
 */
class BasicPageNodeTest extends NodeAccessTestBase
{
  protected BasicPageNode $node;

  protected static $modules = [
    'node',
    'user',
    'system',
    'date'
  ];

  protected function setUp(): void
  {
    parent::setUp();

    $this->node = $this->drupalCreateNode(
      [
        'type' => 'page',
        'title' => 'Page 1',
        'body' => [
          'value' => 'Page 1 body',
          'summary' => 'Page 1 summary',
          'format' => 'full_html',
        ],
      ]
    );
  }

  public function testPageContentTypeExists(): void
  {
    $bundle_info = \Drupal::service('entity_type.bundle.info')->getBundleInfo('node');
    $this->assertArrayHasKey('page', $bundle_info);

    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'page');
    $this->assertArrayHasKey('title', $fields);
    $this->assertArrayHasKey('body', $fields);

    $body_field = $fields['body'];
    $this->assertEquals('text_with_summary', $body_field->getType());
    $this->assertEquals('Body', $body_field->getLabel());
  }

  public function testBasicPageNodeValues(): void
  {
    $this->assertInstanceOf(NodeInterface::class, $this->node);
    $this->assertInstanceOf(BasicPageNode::class, $this->node);

    $this->assertEquals('page', $this->node->bundle());
    $this->assertEquals('Page 1', $this->node->label());
    $this->assertEquals('Page 1 body', $this->node->getBody());
    $this->assertEquals('Page 1 summary', $this->node->getSummary());
  }
}
