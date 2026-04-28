<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Exports\DataExport;
use Zavudev\Exports\ExportCreateParams\DataType;
use Zavudev\Exports\ExportGetResponse;
use Zavudev\Exports\ExportListParams\Status;
use Zavudev\Exports\ExportNewResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ExportsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ExportsService implements ExportsContract
{
    /**
     * @api
     */
    public ExportsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExportsRawService($client);
    }

    /**
     * @api
     *
     * Create a new data export job. The export will be processed asynchronously and the download URL will be available when status is 'completed'. Export links expire after 24 hours.
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
    ): ExportNewResponse {
        $params = Util::removeNulls(
            ['dataTypes' => $dataTypes, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get details of a specific data export, including download URL when completed.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $exportID,
        RequestOptions|array|null $requestOptions = null
    ): ExportGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($exportID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List data exports for this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
