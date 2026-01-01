<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams\DocumentType;

/**
 * Create a regulatory document record after uploading the file. Use the upload-url endpoint first to get an upload URL.
 *
 * @see Zavudev\Services\RegulatoryDocumentsService::create()
 *
 * @phpstan-type RegulatoryDocumentCreateParamsShape = array{
 *   documentType: DocumentType|value-of<DocumentType>,
 *   fileSize: int,
 *   mimeType: string,
 *   name: string,
 *   storageID: string,
 * }
 */
final class RegulatoryDocumentCreateParams implements BaseModel
{
    /** @use SdkModel<RegulatoryDocumentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<DocumentType> $documentType */
    #[Required(enum: DocumentType::class)]
    public string $documentType;

    #[Required]
    public int $fileSize;

    #[Required]
    public string $mimeType;

    #[Required]
    public string $name;

    /**
     * Storage ID from the upload-url endpoint.
     */
    #[Required('storageId')]
    public string $storageID;

    /**
     * `new RegulatoryDocumentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegulatoryDocumentCreateParams::with(
     *   documentType: ..., fileSize: ..., mimeType: ..., name: ..., storageID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegulatoryDocumentCreateParams)
     *   ->withDocumentType(...)
     *   ->withFileSize(...)
     *   ->withMimeType(...)
     *   ->withName(...)
     *   ->withStorageID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param DocumentType|value-of<DocumentType> $documentType
     */
    public static function with(
        DocumentType|string $documentType,
        int $fileSize,
        string $mimeType,
        string $name,
        string $storageID,
    ): self {
        $self = new self;

        $self['documentType'] = $documentType;
        $self['fileSize'] = $fileSize;
        $self['mimeType'] = $mimeType;
        $self['name'] = $name;
        $self['storageID'] = $storageID;

        return $self;
    }

    /**
     * @param DocumentType|value-of<DocumentType> $documentType
     */
    public function withDocumentType(DocumentType|string $documentType): self
    {
        $self = clone $this;
        $self['documentType'] = $documentType;

        return $self;
    }

    public function withFileSize(int $fileSize): self
    {
        $self = clone $this;
        $self['fileSize'] = $fileSize;

        return $self;
    }

    public function withMimeType(string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Storage ID from the upload-url endpoint.
     */
    public function withStorageID(string $storageID): self
    {
        $self = clone $this;
        $self['storageID'] = $storageID;

        return $self;
    }
}
