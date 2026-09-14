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
     * Create a regulatory address, to use as the value of an `address` requirement when buying a phone number. It is registered for review when it is created, with status `pending`.
     *
     * @param string $firstName first name of the person the address is registered to
     * @param string $lastName last name of the person the address is registered to
     * @param string $businessName Business name, when the address belongs to a business. Defaults to the person's full name.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $countryCode,
        string $firstName,
        string $lastName,
        string $locality,
        string $postalCode,
        string $streetAddress,
        ?string $administrativeArea = null,
        ?string $businessName = null,
        ?string $extendedAddress = null,
        RequestOptions|array|null $requestOptions = null,
    ): AddressNewResponse {
        $params = Util::removeNulls(
            [
                'countryCode' => $countryCode,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'locality' => $locality,
                'postalCode' => $postalCode,
                'streetAddress' => $streetAddress,
                'administrativeArea' => $administrativeArea,
                'businessName' => $businessName,
                'extendedAddress' => $extendedAddress,
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
     * Delete a regulatory address from this project. Any address can be deleted, whatever its status. Phone numbers already purchased with it are not affected, and neither is information already submitted for later purchases in its country.
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
