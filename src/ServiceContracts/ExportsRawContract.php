<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Exports\DataExport;
use Zavudev\Exports\ExportCreateParams;
use Zavudev\Exports\ExportGetResponse;
use Zavudev\Exports\ExportListParams;
use Zavudev\Exports\ExportNewResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ExportsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ExportCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExportNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ExportCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<DataExport>>
     *
     * @throws APIException
     */
    public function list(
        array|ExportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
