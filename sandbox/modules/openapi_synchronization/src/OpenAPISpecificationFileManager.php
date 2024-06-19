<?php

declare(strict_types=1);

namespace Drupal\openapi_synchronization;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\Exception\FileException;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\file\FileInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

final class OpenAPISpecificationFileManager
{
    protected array $errors = [];

    public function __construct(
        private AccountInterface $account,
        private FileSystemInterface $fileSystem,
        private EntityTypeManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {
    }

    public function save(
        Request $request,
    ): array|FileInterface {
        $destination = $this->getFilename($request);
        $isUploadable = $this->prepareDirectory($destination);
        if (!$isUploadable) {
            return $this->errors;
        }

        /** @var string $content */
        $content = $request->getContent();
        if (empty($content)) {
            $message = "No content found in the request.";
            $this->logger->error($message);
            $this->errors[] = $message;
            return $this->errors;
        }

        $fileUri = $this->uploadFile($content, $destination);
        if (!$fileUri) {
            return $this->errors;
        }

        $file = $this->createFile($fileUri);
        if (!$file) {
            return $this->errors;
        }

        return $file;
    }

    public function remove(
        FileInterface $file,
    ): void {
        $file->delete();
    }

    private function getFilename(
        Request $request,
    ): string {
        $hasContentDispositionHeader = false;
        $filename = $request->attributes->get('_raw_variables')->get('productName');
        if ($request->headers->has('Content-Disposition') && !empty($request->headers->get('Content-Disposition'))) {
            $filename = $this->getFilenameFromContentDisposition($request->headers->get('Content-Disposition'));
            $hasContentDispositionHeader = true;
        }

        if (
            !$hasContentDispositionHeader &&
            $request->headers->has('Content-Type') && !empty($request->headers->get('Content-Type'))
        ) {
            $extension = $this->getExtensionFromContentType($request->headers->get('Content-Type'));
            $filename = $filename . '.' . $extension;
        }

        return 'public://apidoc_specs' . \DIRECTORY_SEPARATOR . $filename;
    }

    private function prepareDirectory(
        string $destination,
    ): bool {
        $directory = \dirname($destination);

        if (
            !$this->fileSystem->prepareDirectory(
                $directory,
                FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS
            )
        ) {
            $message = "The directory $directory cannot be prepared. Check the permissions.";
            $this->logger->error($message);
            $this->errors[] = $message;

            return false;
        }

        return true;
    }

    private function uploadFile(
        string $content,
        string $destination,
    ): ?string {
        try {
            return $this->fileSystem->saveData(
                $content,
                $destination,
                FileSystemInterface::EXISTS_RENAME
            );
        } catch (FileException $fileException) {
            $message = "An error occured when uploading the file.";
            $this->logger->error($message);
            $this->errors[] = $message;
            return null;
        }
    }

    private function createFile(
        string $fileUri,
    ): ?FileInterface {
        try {
            /** @var FileInterface $file */
            $file = $this->entityManager->getStorage('file')->create(['uri' => $fileUri]);
            $file->setOwnerId($this->account->id());
            $file->setPermanent();
            $file->save();

            return $file;
        } catch (EntityStorageException $storageException) {
            $message = "The file could not be saved in database";
            $this->logger->error($message);
            $this->errors[] = $message;
            return null;
        }
    }

    private function getFilenameFromContentDisposition(
        string $value,
    ): ?string {
        if (preg_match('/filename=\'(.+?)\'/', $value, $matches)) {
            return $matches[1];
        }

        if (preg_match('/filename=([^; ]+)/', $value, $matches)) {
            return rawurldecode($matches[1]);
        }

        return null;
    }

    private function getExtensionFromContentType(
        string $value,
    ): ?string {
        if (preg_match('/(application|text)\/(.+)/', $value, $matches)) {
            return $matches[2];
        }

        return null;
    }
}
