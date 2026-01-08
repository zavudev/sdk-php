<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
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
use Zavudev\ServiceContracts\PhoneNumbersContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class PhoneNumbersService implements PhoneNumbersContract
{
    /**
     * @api
     */
    public PhoneNumbersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PhoneNumbersRawService($client);
    }

    /**
     * @api
     *
     * Get details of a specific phone number.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
    ): PhoneNumberGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($phoneNumberID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a phone number's name or sender assignment.
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
    ): PhoneNumberUpdateResponse {
        $params = Util::removeNulls(['name' => $name, 'senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($phoneNumberID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List all phone numbers owned by this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Purchase an available phone number. The first US phone number is free for each team.
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
    ): PhoneNumberPurchaseResponse {
        $params = Util::removeNulls(
            ['phoneNumber' => $phoneNumber, 'name' => $name]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->purchase(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Release a phone number. The phone number must not be assigned to a sender.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->release($phoneNumberID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get regulatory requirements for purchasing phone numbers in a specific country. Some countries require additional documentation (addresses, identity documents) before phone numbers can be activated.
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
    ): PhoneNumberRequirementsResponse {
        $params = Util::removeNulls(
            ['countryCode' => $countryCode, 'type' => $type]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->requirements(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search for available phone numbers to purchase by country and type.
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
    ): PhoneNumberSearchAvailableResponse {
        $params = Util::removeNulls(
            [
                'countryCode' => $countryCode,
                'contains' => $contains,
                'limit' => $limit,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->searchAvailable(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
