<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Brands\BrandCreateParams;
use Zavudev\Number10dlc\Brands\BrandGetResponse;
use Zavudev\Number10dlc\Brands\BrandListParams;
use Zavudev\Number10dlc\Brands\BrandListUseCasesResponse;
use Zavudev\Number10dlc\Brands\BrandNewResponse;
use Zavudev\Number10dlc\Brands\BrandSubmitResponse;
use Zavudev\Number10dlc\Brands\BrandSyncStatusResponse;
use Zavudev\Number10dlc\Brands\BrandUpdateParams;
use Zavudev\Number10dlc\Brands\BrandUpdateResponse;
use Zavudev\Number10dlc\Brands\TenDlcBrand;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface BrandsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BrandCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BrandCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param array<string,mixed>|BrandUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $brandID,
        array|BrandUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BrandListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<TenDlcBrand>>
     *
     * @throws APIException
     */
    public function list(
        array|BrandListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandListUseCasesResponse>
     *
     * @throws APIException
     */
    public function listUseCases(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandSubmitResponse>
     *
     * @throws APIException
     */
    public function submit(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandSyncStatusResponse>
     *
     * @throws APIException
     */
    public function syncStatus(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
