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
use Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement;
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

/**
 * @phpstan-import-type RegulatoryRequirementShape from \Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $phoneNumberID,
        array|PhoneNumberUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     *   status?: PhoneNumberStatus|value-of<PhoneNumberStatus>,
     * }|PhoneNumberListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<OwnedPhoneNumber>>
     *
     * @throws APIException
     */
    public function list(
        array|PhoneNumberListParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * Purchase an available phone number. Requires a paid plan: the Free plan cannot purchase phone numbers and receives `402` with code `paid_plan_required`.
     *
     * **The included number.** A paid plan includes one number at no charge, once per account: it must be a US or Canadian number (a +1 number) costing $20 a month or less. `isFreeEligible` in `GET /v1/phone-numbers/available` marks the numbers that qualify. Claiming it spends the benefit for good, across every team the account owner owns, so releasing that number does not make another one free.
     *
     * **Numbers with regulatory requirements.** Which numbers need regulatory information is decided per number, not by a fixed country list. The purchase looks the requirements up for the exact number before charging anything:
     *
     * 1. `GET /v1/phone-numbers/requirements?phoneNumber=...`. If `items` is empty, buy normally.
     * 2. Create what it asks for: addresses with `POST /v1/addresses`, documents with `POST /v1/documents`.
     * 3. Purchase with `type` and `regulatoryRequirements`. The number is bought and billed at once with `regulatoryStatus: pending_review`.
     * 4. Poll `GET /v1/phone-numbers/{phoneNumberId}` until `regulatoryStatus` is `approved`. Assign it to a sender before or after approval; it starts carrying messages once approved.
     *
     * **Reuse.** Information you submitted is kept for your project, per country and `type`, and a later purchase there may omit `regulatoryRequirements`. Reuse only happens when what is kept still covers every requirement of the new number and every address and document in it belongs to the project. Otherwise, or when nothing is kept, the purchase returns `400 regulatory_compliance_required` with the missing requirements in `details`.
     *
     * Invalid values (a missing, unknown or repeated requirement id, an address or document from another project, or one rejected in review) return `400 invalid_request`. If an address or document cannot be registered for review, the purchase returns `400 invalid_request` naming the requirement. If the requirements cannot be looked up, the purchase returns `502 requirements_unavailable`, except for US and Canadian numbers, which are sold as numbers without requirements. None of these errors charge anything.
     *
     * @param array{
     *   phoneNumber: string,
     *   name?: string,
     *   regulatoryRequirements?: list<RegulatoryRequirement|RegulatoryRequirementShape>,
     *   type?: PhoneNumberType|value-of<PhoneNumberType>,
     * }|PhoneNumberPurchaseParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberPurchaseResponse>
     *
     * @throws APIException
     */
    public function purchase(
        array|PhoneNumberPurchaseParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null
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
     * Get the regulatory information needed to buy a phone number, for one specific number or for a country and number type. Prefer `phoneNumber`: the response is then exactly the list the purchase of that number validates against. Pass each `requirementTypes[].id` back as `requirementType` in `regulatoryRequirements` on `POST /v1/phone-numbers`.
     *
     * For `phoneNumber`, the requirements of that exact number are returned. When they cannot be resolved for the number itself, the list for its country and `type` is returned instead, and the purchase uses the same list. An empty `items` array means the number needs no regulatory information. If the requirements cannot be retrieved at all, the response is `502 requirements_unavailable`, never an empty list.
     *
     * URL-encode the `+` of `phoneNumber` as `%2B`. An unencoded `+` is also accepted.
     *
     * @param array{
     *   countryCode?: string,
     *   phoneNumber?: string,
     *   type?: PhoneNumberType|value-of<PhoneNumberType>,
     * }|PhoneNumberRequirementsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberRequirementsResponse>
     *
     * @throws APIException
     */
    public function requirements(
        array|PhoneNumberRequirementsParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     *   capabilities?: string,
     *   contains?: string,
     *   limit?: int,
     *   type?: PhoneNumberType|value-of<PhoneNumberType>,
     * }|PhoneNumberSearchAvailableParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberSearchAvailableResponse>
     *
     * @throws APIException
     */
    public function searchAvailable(
        array|PhoneNumberSearchAvailableParams $params,
        RequestOptions|array|null $requestOptions = null,
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
