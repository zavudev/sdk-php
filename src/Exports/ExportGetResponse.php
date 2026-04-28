<?php

declare(strict_types=1);

namespace Zavudev\Exports;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DataExportShape from \Zavudev\Exports\DataExport
 *
 * @phpstan-type ExportGetResponseShape = array{export: DataExport|DataExportShape}
 */
final class ExportGetResponse implements BaseModel
{
    /** @use SdkModel<ExportGetResponseShape> */
    use SdkModel;

    #[Required]
    public DataExport $export;

    /**
     * `new ExportGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExportGetResponse::with(export: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExportGetResponse)->withExport(...)
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
