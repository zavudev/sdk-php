<?php

declare(strict_types=1);

namespace Zavudev\Exports;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Exports\ExportCreateParams\DataType;

/**
 * Create a new data export job. The export will be processed asynchronously and the download URL will be available when status is 'completed'. Export links expire after 24 hours.
 *
 * @see Zavudev\Services\ExportsService::create()
 *
 * @phpstan-type ExportCreateParamsShape = array{
 *   dataTypes: list<DataType|value-of<DataType>>,
 *   dateFrom?: \DateTimeInterface|null,
 *   dateTo?: \DateTimeInterface|null,
 * }
 */
final class ExportCreateParams implements BaseModel
{
    /** @use SdkModel<ExportCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * List of data types to include in the export.
     *
     * @var list<value-of<DataType>> $dataTypes
     */
    #[Required(list: DataType::class)]
    public array $dataTypes;

    /**
     * Start date for data to export (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $dateFrom;

    /**
     * End date for data to export (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $dateTo;

    /**
     * `new ExportCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExportCreateParams::with(dataTypes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExportCreateParams)->withDataTypes(...)
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
     */
    public static function with(
        array $dataTypes,
        ?\DateTimeInterface $dateFrom = null,
        ?\DateTimeInterface $dateTo = null,
    ): self {
        $self = new self;

        $self['dataTypes'] = $dataTypes;

        null !== $dateFrom && $self['dateFrom'] = $dateFrom;
        null !== $dateTo && $self['dateTo'] = $dateTo;

        return $self;
    }

    /**
     * List of data types to include in the export.
     *
     * @param list<DataType|value-of<DataType>> $dataTypes
     */
    public function withDataTypes(array $dataTypes): self
    {
        $self = clone $this;
        $self['dataTypes'] = $dataTypes;

        return $self;
    }

    /**
     * Start date for data to export (inclusive).
     */
    public function withDateFrom(\DateTimeInterface $dateFrom): self
    {
        $self = clone $this;
        $self['dateFrom'] = $dateFrom;

        return $self;
    }

    /**
     * End date for data to export (inclusive).
     */
    public function withDateTo(\DateTimeInterface $dateTo): self
    {
        $self = clone $this;
        $self['dateTo'] = $dateTo;

        return $self;
    }
}
