<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\RegulatoryDocuments\RegulatoryDocument\DocumentType;
use Zavudev\RegulatoryDocuments\RegulatoryDocument\Status;

/**
 * A regulatory document for phone number requirements.
 *
 * @phpstan-type RegulatoryDocumentShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   documentType: DocumentType|value-of<DocumentType>,
 *   name: string,
 *   status: Status|value-of<Status>,
 *   fileSize?: int|null,
 *   mimeType?: string|null,
 *   rejectionReason?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class RegulatoryDocument implements BaseModel
{
    /** @use SdkModel<RegulatoryDocumentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<DocumentType> $documentType */
    #[Required(enum: DocumentType::class)]
    public string $documentType;

    #[Required]
    public string $name;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Optional]
    public ?int $fileSize;

    #[Optional]
    public ?string $mimeType;

    #[Optional(nullable: true)]
    public ?string $rejectionReason;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new RegulatoryDocument()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegulatoryDocument::with(
     *   id: ..., createdAt: ..., documentType: ..., name: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegulatoryDocument)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDocumentType(...)
     *   ->withName(...)
     *   ->withStatus(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        DocumentType|string $documentType,
        string $name,
        Status|string $status,
        ?int $fileSize = null,
        ?string $mimeType = null,
        ?string $rejectionReason = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['documentType'] = $documentType;
        $self['name'] = $name;
        $self['status'] = $status;

        null !== $fileSize && $self['fileSize'] = $fileSize;
        null !== $mimeType && $self['mimeType'] = $mimeType;
        null !== $rejectionReason && $self['rejectionReason'] = $rejectionReason;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

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

    public function withRejectionReason(?string $rejectionReason): self
    {
        $self = clone $this;
        $self['rejectionReason'] = $rejectionReason;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
