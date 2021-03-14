<?php

declare(strict_types=1);

namespace Drupal\node_alias\EventSubscriber;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\node_alias\Entity\PathAlias;
use Drupal\pathauto\AliasStorageHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NodeEventSubscriber implements NodeEventSubscriberInterface, EventSubscriberInterface, ContainerInjectionInterface
{
    use NodeEventSubscriberTrait;

    protected AliasStorageHelperInterface $aliasStorage;

    public function __construct(AliasStorageHelperInterface $aliasStorage)
    {
        $this->aliasStorage = $aliasStorage;
    }

    public static function create(ContainerInterface $container): self
    {
        return new self(
            $container->get('pathauto.alias_storage_helper')
        );
    }

    public static function getSubscribedEvents(): array
    {
        return self::getEvents();
    }

    public function onNodeEdit(EntityInterface $entity, PathAlias $pathAlias, string $op): void
    {
        $langcode = $entity->language()->getId();

        $canonicalPath = '/' . $entity->toUrl('canonical')->getInternalPath();
        $reservationPath = $pathAlias->getSource();

        $canonicalSourcePath = $this->aliasStorage->loadBySource($canonicalPath, $langcode);
        $canonicalSourceAliasPath = $canonicalPath;
        if ($canonicalSourcePath) {
            $canonicalSourceAliasPath = $canonicalSourcePath['alias'];
        }

        $reservationSourcePath = $this->aliasStorage->loadBySource($reservationPath, $langcode);
        if (!$reservationSourcePath) {
            $op = 'insert';
        }

        $path = [
            'source'   => $reservationPath,
            'alias'    => sprintf($pathAlias->getDestination(), $canonicalSourceAliasPath),  // "{$canonicalSourceAliasPath}/reservation",
            'language' => $langcode,
        ];

        $this->aliasStorage->save($path, $reservationSourcePath, $op);
    }

    public function onNodeDelete(EntityInterface $entity, PathAlias $pathAlias): void
    {
        if ($entity->hasLinkTemplate('canonical') &&
            $entity instanceof ContentEntityInterface &&
            $entity->hasField('path') &&
            $entity->getFieldDefinition('path')->getType() === 'path') {
            $this->aliasStorage->deleteBySourcePrefix($pathAlias->getSource());
        }
    }
}
