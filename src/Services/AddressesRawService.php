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

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
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
     * Create a regulatory address, to use as the value of an `address` requirement when buying a phone number. It is registered for review when it is created, with status `pending`.
     *
     * @param array{
     *   countryCode: string,
     *   firstName: string,
     *   lastName: string,
     *   locality: string,
     *   postalCode: string,
     *   streetAddress: string,
     *   administrativeArea?: string,
     *   businessName?: string,
     *   extendedAddress?: string,
     * }|AddressCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AddressNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AddressCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AddressGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Address>>
     *
     * @throws APIException
     */
    public function list(
        array|AddressListParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * Delete a regulatory address from this project. Any address can be deleted, whatever its status. Phone numbers already purchased with it are not affected, and neither is information already submitted for later purchases in its country.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
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
