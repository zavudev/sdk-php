<?php

declare(strict_types=1);

namespace Zavudev\Exports;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Exports\DataExport\DataType;
use Zavudev\Exports\DataExport\Status;

/**
 * @phpstan-type DataExportShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   dataTypes: list<DataType|value-of<DataType>>,
 *   expiresAt: \DateTimeInterface,
 *   status: Status|value-of<Status>,
 *   completedAt?: \DateTimeInterface|null,
 *   dateFrom?: \DateTimeInterface|null,
 *   dateTo?: \DateTimeInterface|null,
 *   downloadURL?: string|null,
 *   errorMessage?: string|null,
 *   fileSize?: int|null,
 * }
 */
final class DataExport implements BaseModel
{
    /** @use SdkModel<DataExportShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var list<value-of<DataType>> $dataTypes */
    #[Required(list: DataType::class)]
    public array $dataTypes;

    /**
     * When the export download link expires (24 hours after creation).
     */
    #[Required]
    public \DateTimeInterface $expiresAt;

    /**
     * Status of a data export job.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $completedAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $dateFrom;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $dateTo;

    /**
     * URL to download the export file. Only available when status is 'completed'.
     */
    #[Optional('downloadUrl', nullable: true)]
    public ?string $downloadURL;

    /**
     * Error message if the export failed.
     */
    #[Optional(nullable: true)]
    public ?string $errorMessage;

    /**
     * Size of the export file in bytes.
     */
    #[Optional(nullable: true)]
    public ?int $fileSize;

    /**
     * `new DataExport()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DataExport::with(
     *   id: ..., createdAt: ..., dataTypes: ..., expiresAt: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DataExport)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDataTypes(...)
     *   ->withExpiresAt(...)
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
     * @param list<DataType|value-of<DataType>> $dataTypes
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $dataTypes,
        \DateTimeInterface $expiresAt,
        Status|string $status,
        ?\DateTimeInterface $completedAt = null,
        ?\DateTimeInterface $dateFrom = null,
        ?\DateTimeInterface $dateTo = null,
        ?string $downloadURL = null,
        ?string $errorMessage = null,
        ?int $fileSize = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['dataTypes'] = $dataTypes;
        $self['expiresAt'] = $expiresAt;
        $self['status'] = $status;

        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $dateFrom && $self['dateFrom'] = $dateFrom;
        null !== $dateTo && $self['dateTo'] = $dateTo;
        null !== $downloadURL && $self['downloadURL'] = $downloadURL;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $fileSize && $self['fileSize'] = $fileSize;

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
     * @param list<DataType|value-of<DataType>> $dataTypes
     */
    public function withDataTypes(array $dataTypes): self
    {
        $self = clone $this;
        $self['dataTypes'] = $dataTypes;

        return $self;
    }

    /**
     * When the export download link expires (24 hours after creation).
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Status of a data export job.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    public function withDateFrom(?\DateTimeInterface $dateFrom): self
    {
        $self = clone $this;
        $self['dateFrom'] = $dateFrom;

        return $self;
    }

    public function withDateTo(?\DateTimeInterface $dateTo): self
    {
        $self = clone $this;
        $self['dateTo'] = $dateTo;

        return $self;
    }

    /**
     * URL to download the export file. Only available when status is 'completed'.
     */
    public function withDownloadURL(?string $downloadURL): self
    {
        $self = clone $this;
        $self['downloadURL'] = $downloadURL;

        return $self;
    }

    /**
     * Error message if the export failed.
     */
    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    /**
     * Size of the export file in bytes.
     */
    public function withFileSize(?int $fileSize): self
    {
        $self = clone $this;
        $self['fileSize'] = $fileSize;

        return $self;
    }
}
