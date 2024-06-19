<?php

declare(strict_types=1);

namespace Drupal\openapi_synchronization;

use Drupal\entity_reference_revisions\EntityReferenceRevisionsFieldItemList;
use Drupal\file\FileInterface;
use Drupal\file\Plugin\Field\FieldType\FileFieldItemList;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\ParagraphInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolation;

final class OpenAPISpecificationProductManager
{
    protected array $errors = [];

    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function updateOpenAPIFileFromEntity(
        NodeInterface $entity,
        FileInterface $file,
    ): array {
        /** @var EntityReferenceRevisionsFieldItemList $fieldSpecification */
        $fieldSpecification = $entity->get('field_documentation');
        /** @var ParagraphInterface[] $fieldSpecificationItems */
        $fieldSpecificationItems = $fieldSpecification->referencedEntities();
        foreach ($fieldSpecificationItems as $fieldSpecification) {
            $this->setFile($fieldSpecification, $file);
        }

        return $this->errors;
    }

    public function getOpenAPIFileFromEntity(
        NodeInterface $entity,
    ): ?FileInterface {
        /** @var EntityReferenceRevisionsFieldItemList $fieldSpecification */
        $fieldSpecification = $entity->get('field_documentation');
        /** @var ParagraphInterface[] $fieldSpecificationItems */
        $fieldSpecificationItems = $fieldSpecification->referencedEntities();
        foreach ($fieldSpecificationItems as $fieldSpecification) {
            /** @var FileFieldItemList $fileField */
            $fileField = $fieldSpecification->get('field_apidoc_spec');
            /** @var FileInterface[] $file */
            $file = $fileField->referencedEntities();
            if (!empty($file)) {
                return reset($file);
            }
        }
        return null;
    }

    private function setFile(
        ParagraphInterface $entity,
        FileInterface $file,
    ): void {
        $entity->set('field_apidoc_spec', ['target_id' => $file->id()]);

        $violations = $entity->get('field_apidoc_spec')->validate();
        if ($violations->count() > 0) {
            /** @var ConstraintViolation[] $violations */
            foreach ($violations as $violation) {
                $message = (string)$violation->getMessage();
                $this->logger->error($message);
                $this->errors[] = $message;
                return;
            }
        }

        $entity->save();
    }
}
