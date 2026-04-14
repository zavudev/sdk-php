<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Exports\DataExport;
use Zavudev\Exports\ExportCreateParams;
use Zavudev\Exports\ExportCreateParams\DataType;
use Zavudev\Exports\ExportGetResponse;
use Zavudev\Exports\ExportListParams;
use Zavudev\Exports\ExportListParams\Status;
use Zavudev\Exports\ExportNewResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ExportsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ExportsRawService implements ExportsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new data export job. The export will be processed asynchronously and the download URL will be available when status is 'completed'. Export links expire after 24 hours.
     *
     * @param array{
     *   dataTypes: list<DataType|value-of<DataType>>,
     *   dateFrom?: \DateTimeInterface,
     *   dateTo?: \DateTimeInterface,
     * }|ExportCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExportNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ExportCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExportCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/exports',
            body: (object) $parsed,
            options: $options,
            convert: ExportNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get details of a specific data export, including download URL when completed.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExportGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $exportID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/exports/%1$s', $exportID],
            options: $requestOptions,
            convert: ExportGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List data exports for this project.
     *
     * @param array{
     *   cursor?: string, limit?: int, status?: Status|value-of<Status>
     * }|ExportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<DataExport>>
     *
     * @throws APIException
     */
    public function list(
        array|ExportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExportListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/exports',
            query: $parsed,
            options: $options,
            convert: DataExport::class,
            page: Cursor::class,
        );
    }
}
