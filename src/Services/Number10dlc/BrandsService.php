<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
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
use Zavudev\ServiceContracts\Number10dlc\BrandsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class BrandsService implements BrandsContract
{
    /**
     * @api
     */
    public BrandsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BrandsRawService($client);
    }

    /**
     * @api
     *
     * Create a 10DLC brand registration. The brand starts in draft status. Submit it for review using the submit endpoint.
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
    ): BrandNewResponse {
        $params = Util::removeNulls(
            [
                'city' => $city,
                'country' => $country,
                'displayName' => $displayName,
                'email' => $email,
                'entityType' => $entityType,
                'phone' => $phone,
                'postalCode' => $postalCode,
                'state' => $state,
                'street' => $street,
                'vertical' => $vertical,
                'companyName' => $companyName,
                'ein' => $ein,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'stockExchange' => $stockExchange,
                'stockSymbol' => $stockSymbol,
                'website' => $website,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get 10DLC brand
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($brandID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a 10DLC brand in draft status. Cannot update after submission.
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
    ): BrandUpdateResponse {
        $params = Util::removeNulls(
            [
                'city' => $city,
                'companyName' => $companyName,
                'country' => $country,
                'displayName' => $displayName,
                'ein' => $ein,
                'email' => $email,
                'entityType' => $entityType,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'phone' => $phone,
                'postalCode' => $postalCode,
                'state' => $state,
                'stockExchange' => $stockExchange,
                'stockSymbol' => $stockSymbol,
                'street' => $street,
                'vertical' => $vertical,
                'website' => $website,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($brandID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List 10DLC brand registrations for this project.
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
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete 10DLC brand
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($brandID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List available use cases for 10DLC campaign registration.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listUseCases(
        RequestOptions|array|null $requestOptions = null
    ): BrandListUseCasesResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listUseCases(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Submit a draft brand to The Campaign Registry (TCR) for vetting. The brand must be in draft status. A $35 registration fee is charged from your balance.
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandSubmitResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->submit($brandID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sync the brand status with the registration provider. Use this to check for approval updates after submission.
     *
     * @param string $brandID 10DLC brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function syncStatus(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BrandSyncStatusResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->syncStatus($brandID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
