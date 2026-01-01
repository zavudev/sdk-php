<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\PhoneNumbers\OwnedPhoneNumber;
use Zavudev\PhoneNumbers\PhoneNumberGetResponse;
use Zavudev\PhoneNumbers\PhoneNumberListParams;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseParams;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseResponse;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsParams;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsResponse;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableParams;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableResponse;
use Zavudev\PhoneNumbers\PhoneNumberStatus;
use Zavudev\PhoneNumbers\PhoneNumberType;
use Zavudev\PhoneNumbers\PhoneNumberUpdateParams;
use Zavudev\PhoneNumbers\PhoneNumberUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\PhoneNumbersRawContract;

final class PhoneNumbersRawService implements PhoneNumbersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get details of a specific phone number.
     *
     * @return BaseResponse<PhoneNumberGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/phone-numbers/%1$s', $phoneNumberID],
            options: $requestOptions,
            convert: PhoneNumberGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a phone number's name or sender assignment.
     *
     * @param array{
     *   name?: string|null, senderID?: string|null
     * }|PhoneNumberUpdateParams $params
     *
     * @return BaseResponse<PhoneNumberUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $phoneNumberID,
        array|PhoneNumberUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/phone-numbers/%1$s', $phoneNumberID],
            body: (object) $parsed,
            options: $options,
            convert: PhoneNumberUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List all phone numbers owned by this project.
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: 'active'|'suspended'|'pending'|PhoneNumberStatus,
     * }|PhoneNumberListParams $params
     *
     * @return BaseResponse<Cursor<OwnedPhoneNumber>>
     *
     * @throws APIException
     */
    public function list(
        array|PhoneNumberListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/phone-numbers',
            query: $parsed,
            options: $options,
            convert: OwnedPhoneNumber::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Purchase an available phone number. The first US phone number is free for each team.
     *
     * @param array{
     *   phoneNumber: string, name?: string
     * }|PhoneNumberPurchaseParams $params
     *
     * @return BaseResponse<PhoneNumberPurchaseResponse>
     *
     * @throws APIException
     */
    public function purchase(
        array|PhoneNumberPurchaseParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberPurchaseParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/phone-numbers',
            body: (object) $parsed,
            options: $options,
            convert: PhoneNumberPurchaseResponse::class,
        );
    }

    /**
     * @api
     *
     * Release a phone number. The phone number must not be assigned to a sender.
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/phone-numbers/%1$s', $phoneNumberID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Get regulatory requirements for purchasing phone numbers in a specific country. Some countries require additional documentation (addresses, identity documents) before phone numbers can be activated.
     *
     * @param array{
     *   countryCode: string, type?: 'local'|'mobile'|'tollFree'|PhoneNumberType
     * }|PhoneNumberRequirementsParams $params
     *
     * @return BaseResponse<PhoneNumberRequirementsResponse>
     *
     * @throws APIException
     */
    public function requirements(
        array|PhoneNumberRequirementsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberRequirementsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/phone-numbers/requirements',
            query: $parsed,
            options: $options,
            convert: PhoneNumberRequirementsResponse::class,
        );
    }

    /**
     * @api
     *
     * Search for available phone numbers to purchase by country and type.
     *
     * @param array{
     *   countryCode: string,
     *   contains?: string,
     *   limit?: int,
     *   type?: 'local'|'mobile'|'tollFree'|PhoneNumberType,
     * }|PhoneNumberSearchAvailableParams $params
     *
     * @return BaseResponse<PhoneNumberSearchAvailableResponse>
     *
     * @throws APIException
     */
    public function searchAvailable(
        array|PhoneNumberSearchAvailableParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberSearchAvailableParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/phone-numbers/available',
            query: $parsed,
            options: $options,
            convert: PhoneNumberSearchAvailableResponse::class,
        );
    }
}
