<?php

declare(strict_types=1);

namespace Drupal\entity_alias\EventSubscriber;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\entity_alias\Entity\PathAlias;
use Drupal\pathauto\AliasStorageHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EntityEventSubscriber implements EntityEventSubscriberInterface, EventSubscriberInterface, ContainerInjectionInterface
{
    use EntityEventSubscriberTrait;

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

    public function onEntityEdit(EntityInterface $entity, PathAlias $pathAlias, string $op): void
    {
        $langcode = $entity->language()->getId();

        $canonicalPath = '/' . $entity->toUrl('canonical')->getInternalPath();
        $sourcePath = $pathAlias->getSource();

        $canonicalSourcePath = $this->aliasStorage->loadBySource($canonicalPath, $langcode);
        $canonicalSourceAliasPath = $canonicalPath;
        if ($canonicalSourcePath) {
            $canonicalSourceAliasPath = $canonicalSourcePath['alias'];
        }

        $reservationSourcePath = $this->aliasStorage->loadBySource($sourcePath, $langcode);
        if (!$reservationSourcePath) {
            $op = 'insert';
        }

        $path = [
            'source'   => $sourcePath,
            'alias'    => sprintf($pathAlias->getDestination(), $canonicalSourceAliasPath),
            'language' => $langcode,
        ];

        $this->aliasStorage->save($path, $reservationSourcePath, $op);
    }

    public function onEntityDelete(EntityInterface $entity, PathAlias $pathAlias): void
    {
        if ($entity->hasLinkTemplate('canonical') &&
            $entity instanceof ContentEntityInterface &&
            $entity->hasField('path') &&
            $entity->getFieldDefinition('path') !== null &&
            $entity->getFieldDefinition('path')->getType() === 'path') {
            $this->aliasStorage->deleteBySourcePrefix($pathAlias->getSource());
        }
    }
}
