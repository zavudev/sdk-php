<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Addresses\Address;
use Zavudev\Addresses\AddressGetResponse;
use Zavudev\Addresses\AddressNewResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\AddressesContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AddressesService implements AddressesContract
{
    /**
     * @api
     */
    public AddressesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AddressesRawService($client);
    }

    /**
     * @api
     *
     * Create a regulatory address for phone number purchases. Some countries require a verified address before phone numbers can be activated.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $countryCode,
        string $locality,
        string $postalCode,
        string $streetAddress,
        ?string $administrativeArea = null,
        ?string $businessName = null,
        ?string $extendedAddress = null,
        ?string $firstName = null,
        ?string $lastName = null,
        RequestOptions|array|null $requestOptions = null,
    ): AddressNewResponse {
        $params = Util::removeNulls(
            [
                'countryCode' => $countryCode,
                'locality' => $locality,
                'postalCode' => $postalCode,
                'streetAddress' => $streetAddress,
                'administrativeArea' => $administrativeArea,
                'businessName' => $businessName,
                'extendedAddress' => $extendedAddress,
                'firstName' => $firstName,
                'lastName' => $lastName,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a specific regulatory address.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
    ): AddressGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($addressID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List regulatory addresses for this project.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Address>
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
     * Delete a regulatory address. Cannot delete addresses that are in use.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($addressID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
