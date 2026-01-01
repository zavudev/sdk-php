<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Addresses\Address;
use Zavudev\Addresses\AddressCreateParams;
use Zavudev\Addresses\AddressGetResponse;
use Zavudev\Addresses\AddressListParams;
use Zavudev\Addresses\AddressNewResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\AddressesRawContract;

final class AddressesRawService implements AddressesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a regulatory address for phone number purchases. Some countries require a verified address before phone numbers can be activated.
     *
     * @param array{
     *   countryCode: string,
     *   locality: string,
     *   postalCode: string,
     *   streetAddress: string,
     *   administrativeArea?: string,
     *   businessName?: string,
     *   extendedAddress?: string,
     *   firstName?: string,
     *   lastName?: string,
     * }|AddressCreateParams $params
     *
     * @return BaseResponse<AddressNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AddressCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = AddressCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/addresses',
            body: (object) $parsed,
            options: $options,
            convert: AddressNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get a specific regulatory address.
     *
     * @return BaseResponse<AddressGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/addresses/%1$s', $addressID],
            options: $requestOptions,
            convert: AddressGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List regulatory addresses for this project.
     *
     * @param array{cursor?: string, limit?: int}|AddressListParams $params
     *
     * @return BaseResponse<Cursor<Address>>
     *
     * @throws APIException
     */
    public function list(
        array|AddressListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = AddressListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/addresses',
            query: $parsed,
            options: $options,
            convert: Address::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a regulatory address. Cannot delete addresses that are in use.
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/addresses/%1$s', $addressID],
            options: $requestOptions,
            convert: null,
        );
    }
}
