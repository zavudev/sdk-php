<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Brands\BrandCreateParams\EntityType;
use Zavudev\Number10dlc\Brands\BrandGetResponse;
use Zavudev\Number10dlc\Brands\BrandListUseCasesResponse;
use Zavudev\Number10dlc\Brands\BrandNewResponse;
use Zavudev\Number10dlc\Brands\BrandSubmitResponse;
use Zavudev\Number10dlc\Brands\BrandSyncStatusResponse;
use Zavudev\Number10dlc\Brands\BrandUpdateResponse;
use Zavudev\Number10dlc\Brands\TenDlcBrand;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface BrandsContract
{
    /**
     * @api
     *
     * @param string $country two-letter ISO country code
     * @param string $displayName display name of the brand
     * @param EntityType|value-of<EntityType> $entityType business entity type for 10DLC brand registration
     * @param string $phone Contact phone in E.164 format.
     * @param string $vertical industry vertical
     * @param string $companyName legal company name
     * @param string $ein employer Identification Number (format: XX-XXXXXXX)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $city,
        string $country,
        string $displayName,
        string $email,
        EntityType|string $entityType,
        string $phone,
        string $postalCode,
        string $state,
        string $street,
        string $vertical,
        ?string $companyName = null,
        ?string $ein = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $stockExchange = null,
        ?string $stockSymbol = null,
        ?string $website = null,
        RequestOptions|array|null $requestOptions = null,
    ): BrandNewResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandGetResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param \Zavudev\Number10dlc\Brands\BrandUpdateParams\EntityType|value-of<\Zavudev\Number10dlc\Brands\BrandUpdateParams\EntityType> $entityType business entity type for 10DLC brand registration
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $brandID,
        ?string $city = null,
        ?string $companyName = null,
        ?string $country = null,
        ?string $displayName = null,
        ?string $ein = null,
        ?string $email = null,
        \Zavudev\Number10dlc\Brands\BrandUpdateParams\EntityType|string|null $entityType = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?string $postalCode = null,
        ?string $state = null,
        ?string $stockExchange = null,
        ?string $stockSymbol = null,
        ?string $street = null,
        ?string $vertical = null,
        ?string $website = null,
        RequestOptions|array|null $requestOptions = null,
    ): BrandUpdateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<TenDlcBrand>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listUseCases(
        RequestOptions|array|null $requestOptions = null
    ): BrandListUseCasesResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandSubmitResponse;

    /**
     * @api
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function syncStatus(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandSyncStatusResponse;
}
