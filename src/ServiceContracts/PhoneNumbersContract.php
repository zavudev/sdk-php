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

interface PhoneNumbersContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): PhoneNumberGetResponse;

    /**
     * @api
     *
     * @param string|null $name Custom name for the phone number. Set to null to clear.
     * @param string|null $senderID Sender ID to assign the phone number to. Set to null to unassign.
     *
     * @throws APIException
     */
    public function update(
        string $phoneNumberID,
        ?string $name = null,
        ?string $senderID = null,
        ?RequestOptions $requestOptions = null,
    ): PhoneNumberUpdateResponse;

    /**
     * @api
     *
     * @param string $cursor pagination cursor
     * @param 'active'|'suspended'|'pending'|PhoneNumberStatus $status filter by phone number status
     *
     * @return Cursor<OwnedPhoneNumber>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        string|PhoneNumberStatus|null $status = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $phoneNumber Phone number in E.164 format.
     * @param string $name optional custom name for the phone number
     *
     * @throws APIException
     */
    public function purchase(
        string $phoneNumber,
        ?string $name = null,
        ?RequestOptions $requestOptions = null,
    ): PhoneNumberPurchaseResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $countryCode two-letter ISO country code
     * @param 'local'|'mobile'|'tollFree'|PhoneNumberType $type type of phone number (local, mobile, tollFree)
     *
     * @throws APIException
     */
    public function requirements(
        string $countryCode,
        string|PhoneNumberType|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): PhoneNumberRequirementsResponse;

    /**
     * @api
     *
     * @param string $countryCode two-letter ISO country code
     * @param string $contains search for numbers containing this string
     * @param int $limit maximum number of results to return
     * @param 'local'|'mobile'|'tollFree'|PhoneNumberType $type type of phone number to search for
     *
     * @throws APIException
     */
    public function searchAvailable(
        string $countryCode,
        ?string $contains = null,
        int $limit = 10,
        string|PhoneNumberType|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): PhoneNumberSearchAvailableResponse;
}
