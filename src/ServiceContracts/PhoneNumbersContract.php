<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\PhoneNumbers\OwnedPhoneNumber;
use Zavudev\PhoneNumbers\PhoneNumberGetResponse;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseResponse;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsResponse;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableResponse;
use Zavudev\PhoneNumbers\PhoneNumberStatus;
use Zavudev\PhoneNumbers\PhoneNumberType;
use Zavudev\PhoneNumbers\PhoneNumberUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface PhoneNumbersContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
    ): PhoneNumberGetResponse;

    /**
     * @api
     *
     * @param string|null $name Custom name for the phone number. Set to null to clear.
     * @param string|null $senderID Sender ID to assign the phone number to. Set to null to unassign.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $phoneNumberID,
        ?string $name = null,
        ?string $senderID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberUpdateResponse;

    /**
     * @api
     *
     * @param string $cursor pagination cursor
     * @param PhoneNumberStatus|value-of<PhoneNumberStatus> $status filter by phone number status
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<OwnedPhoneNumber>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        PhoneNumberStatus|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $phoneNumber Phone number in E.164 format.
     * @param string $name optional custom name for the phone number
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function purchase(
        string $phoneNumber,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberPurchaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $countryCode two-letter ISO country code
     * @param PhoneNumberType|value-of<PhoneNumberType> $type type of phone number (local, mobile, tollFree)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function requirements(
        string $countryCode,
        PhoneNumberType|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberRequirementsResponse;

    /**
     * @api
     *
     * @param string $countryCode two-letter ISO country code
     * @param string $contains search for numbers containing this string
     * @param int $limit maximum number of results to return
     * @param PhoneNumberType|value-of<PhoneNumberType> $type type of phone number to search for
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function searchAvailable(
        string $countryCode,
        ?string $contains = null,
        int $limit = 10,
        PhoneNumberType|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberSearchAvailableResponse;
}
