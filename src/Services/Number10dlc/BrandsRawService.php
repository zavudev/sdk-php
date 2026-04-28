<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Brands\BrandCreateParams;
use Zavudev\Number10dlc\Brands\BrandCreateParams\EntityType;
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
use Zavudev\ServiceContracts\Number10dlc\BrandsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class BrandsRawService implements BrandsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a 10DLC brand registration. The brand starts in draft status. Submit it for review using the submit endpoint.
     *
     * @param array{
     *   city: string,
     *   country: string,
     *   displayName: string,
     *   email: string,
     *   entityType: EntityType|value-of<EntityType>,
     *   phone: string,
     *   postalCode: string,
     *   state: string,
     *   street: string,
     *   vertical: string,
     *   companyName?: string,
     *   ein?: string,
     *   firstName?: string,
     *   lastName?: string,
     *   stockExchange?: string,
     *   stockSymbol?: string,
     *   website?: string,
     * }|BrandCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BrandCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BrandCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/10dlc/brands',
            body: (object) $parsed,
            options: $options,
            convert: BrandNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get 10DLC brand
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/10dlc/brands/%1$s', $brandID],
            options: $requestOptions,
            convert: BrandGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a 10DLC brand in draft status. Cannot update after submission.
     *
     * @param string $brandID 10DLC brand ID
     * @param array{
     *   city?: string,
     *   companyName?: string,
     *   country?: string,
     *   displayName?: string,
     *   ein?: string,
     *   email?: string,
     *   entityType?: BrandUpdateParams\EntityType|value-of<BrandUpdateParams\EntityType>,
     *   firstName?: string,
     *   lastName?: string,
     *   phone?: string,
     *   postalCode?: string,
     *   state?: string,
     *   stockExchange?: string,
     *   stockSymbol?: string,
     *   street?: string,
     *   vertical?: string,
     *   website?: string,
     * }|BrandUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BrandUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/10dlc/brands/%1$s', $brandID],
            body: (object) $parsed,
            options: $options,
            convert: BrandUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List 10DLC brand registrations for this project.
     *
     * @param array{cursor?: string, limit?: int}|BrandListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<TenDlcBrand>>
     *
     * @throws APIException
     */
    public function list(
        array|BrandListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BrandListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/10dlc/brands',
            query: $parsed,
            options: $options,
            convert: TenDlcBrand::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete 10DLC brand
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/10dlc/brands/%1$s', $brandID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * List available use cases for 10DLC campaign registration.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandListUseCasesResponse>
     *
     * @throws APIException
     */
    public function listUseCases(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/10dlc/brands/use-cases',
            options: $requestOptions,
            convert: BrandListUseCasesResponse::class,
        );
    }

    /**
     * @api
     *
     * Submit a draft brand to The Campaign Registry (TCR) for vetting. The brand must be in draft status. A $35 registration fee is charged from your balance.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/10dlc/brands/%1$s/submit', $brandID],
            options: $requestOptions,
            convert: BrandSubmitResponse::class,
        );
    }

    /**
     * @api
     *
     * Sync the brand status with the registration provider. Use this to check for approval updates after submission.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/10dlc/brands/%1$s/sync', $brandID],
            options: $requestOptions,
            convert: BrandSyncStatusResponse::class,
        );
    }
}
