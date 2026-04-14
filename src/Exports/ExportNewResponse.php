<?php

declare(strict_types=1);

namespace Zavudev\Exports;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DataExportShape from \Zavudev\Exports\DataExport
 *
 * @phpstan-type ExportNewResponseShape = array{export: DataExport|DataExportShape}
 */
final class ExportNewResponse implements BaseModel
{
    /** @use SdkModel<ExportNewResponseShape> */
    use SdkModel;

    #[Required]
    public DataExport $export;

    /**
     * `new ExportNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExportNewResponse::with(export: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExportNewResponse)->withExport(...)
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
     * @param DataExport|DataExportShape $export
     */
    public static function with(DataExport|array $export): self
    {
        $self = new self;

        $self['export'] = $export;

        return $self;
    }

    /**
     * @param DataExport|DataExportShape $export
     */
    public function withExport(DataExport|array $export): self
    {
        $self = clone $this;
        $self['export'] = $export;

        return $self;
    }
}
