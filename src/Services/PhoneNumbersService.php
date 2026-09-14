<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\PhoneNumbers\OwnedPhoneNumber;
use Zavudev\PhoneNumbers\PhoneNumberGetResponse;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseResponse;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsResponse;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableResponse;
use Zavudev\PhoneNumbers\PhoneNumberStatus;
use Zavudev\PhoneNumbers\PhoneNumberType;
use Zavudev\PhoneNumbers\PhoneNumberUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\PhoneNumbersContract;

/**
 * @phpstan-import-type RegulatoryRequirementShape from \Zavudev\PhoneNumbers\PhoneNumberPurchaseParams\RegulatoryRequirement
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
     * @param string|null $senderID Sender ID to assign the phone number to. Set to null to unassign. A number under regulatory review is recorded now and connected to the sender when approved; a rejected number is refused.
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
     * @param string $phoneNumber Phone number in E.164 format.
     * @param string $name optional custom name for the phone number
     * @param list<RegulatoryRequirement|RegulatoryRequirementShape> $regulatoryRequirements Regulatory information, for numbers whose requirements list is not empty. Get the list with `GET /v1/phone-numbers/requirements?phoneNumber=...` and send one entry per requirement id, except `action` requirements, which take no value. Every required id must be present, once, and no unknown id may be sent; otherwise the purchase is refused with `400 invalid_request` before anything is charged.
     *
     * The information is kept for your project under the number's country and `type`. A later purchase there may omit this field if what is kept still covers that number's requirements. Omit it for numbers without requirements.
     * @param PhoneNumberType|value-of<PhoneNumberType> $type Type of phone number. `mobile` is stocked in countries where no geographic (`local`) or non-geographic (`national`) inventory exists, and in several markets it is the only type that can receive SMS.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function purchase(
        string $phoneNumber,
        ?string $name = null,
        ?array $regulatoryRequirements = null,
        PhoneNumberType|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberPurchaseResponse {
        $params = Util::removeNulls(
            [
                'phoneNumber' => $phoneNumber,
                'name' => $name,
                'regulatoryRequirements' => $regulatoryRequirements,
                'type' => $type,
            ],
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
     * Get the regulatory information needed to buy a phone number, for one specific number or for a country and number type. Prefer `phoneNumber`: the response is then exactly the list the purchase of that number validates against. Pass each `requirementTypes[].id` back as `requirementType` in `regulatoryRequirements` on `POST /v1/phone-numbers`.
     *
     * For `phoneNumber`, the requirements of that exact number are returned. When they cannot be resolved for the number itself, the list for its country and `type` is returned instead, and the purchase uses the same list. An empty `items` array means the number needs no regulatory information. If the requirements cannot be retrieved at all, the response is `502 requirements_unavailable`, never an empty list.
     *
     * URL-encode the `+` of `phoneNumber` as `%2B`. An unencoded `+` is also accepted.
     *
     * @param string $countryCode Two-letter ISO country code. Required unless `phoneNumber` is given.
     * @param string $phoneNumber E.164 number from `GET /v1/phone-numbers/available`, with `+` encoded as `%2B`. Returns the requirements the purchase of that number checks. Takes precedence over `countryCode`.
     * @param PhoneNumberType|value-of<PhoneNumberType> $type Type of phone number (local, national, mobile, tollFree). Defaults to `local`. With `phoneNumber`, used only when the number's own requirements cannot be resolved and the country list is returned.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function requirements(
        ?string $countryCode = null,
        ?string $phoneNumber = null,
        PhoneNumberType|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberRequirementsResponse {
        $params = Util::removeNulls(
            [
                'countryCode' => $countryCode,
                'phoneNumber' => $phoneNumber,
                'type' => $type,
            ],
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
     * @param string $capabilities Comma-separated capabilities the number must have: `sms`, `voice`, `mms`. Numbers missing any of them are dropped.
     * @param string $contains search for numbers containing this string
     * @param int $limit maximum number of results to return
     * @param PhoneNumberType|value-of<PhoneNumberType> $type type of phone number to search for
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function searchAvailable(
        string $countryCode,
        ?string $capabilities = null,
        ?string $contains = null,
        int $limit = 10,
        PhoneNumberType|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberSearchAvailableResponse {
        $params = Util::removeNulls(
            [
                'countryCode' => $countryCode,
                'capabilities' => $capabilities,
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
