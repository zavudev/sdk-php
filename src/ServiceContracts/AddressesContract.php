<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Addresses\Address;
use Zavudev\Addresses\AddressGetResponse;
use Zavudev\Addresses\AddressNewResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface AddressesContract
{
    /**
     * @api
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
    ): AddressNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
    ): AddressGetResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
