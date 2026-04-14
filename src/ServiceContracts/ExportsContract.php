<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Exports\DataExport;
use Zavudev\Exports\ExportCreateParams\DataType;
use Zavudev\Exports\ExportGetResponse;
use Zavudev\Exports\ExportListParams\Status;
use Zavudev\Exports\ExportNewResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ExportsContract
{
    /**
     * @api
     *
     * @param list<DataType|value-of<DataType>> $dataTypes list of data types to include in the export
     * @param \DateTimeInterface $dateFrom start date for data to export (inclusive)
     * @param \DateTimeInterface $dateTo end date for data to export (inclusive)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $dataTypes,
        ?\DateTimeInterface $dateFrom = null,
        ?\DateTimeInterface $dateTo = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExportNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $exportID,
        RequestOptions|array|null $requestOptions = null
    ): ExportGetResponse;

    /**
     * @api
     *
     * @param Status|value-of<Status> $status status of a data export job
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<DataExport>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        Status|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;
}
