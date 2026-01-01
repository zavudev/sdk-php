<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Addresses\Address;
use Zavudev\Addresses\AddressGetResponse;
use Zavudev\Addresses\AddressNewResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface AddressesContract
{
    /**
     * @api
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
        ?RequestOptions $requestOptions = null,
    ): AddressNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): AddressGetResponse;

    /**
     * @api
     *
     * @return Cursor<Address>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
