<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc\Campaigns;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignParams;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberListResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberUnassignParams;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Number10dlc\Campaigns\PhoneNumbersRawContract;

/**
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
     * List phone numbers assigned to a 10DLC campaign.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/10dlc/campaigns/%1$s/phone-numbers', $campaignID],
            options: $requestOptions,
            convert: PhoneNumberListResponse::class,
        );
    }

    /**
     * @api
     *
     * Assign a US phone number to an approved 10DLC campaign. The campaign must be in approved status.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param array{phoneNumberID: string}|PhoneNumberAssignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PhoneNumberAssignResponse>
     *
     * @throws APIException
     */
    public function assign(
        string $campaignID,
        array|PhoneNumberAssignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberAssignParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/10dlc/campaigns/%1$s/phone-numbers', $campaignID],
            body: (object) $parsed,
            options: $options,
            convert: PhoneNumberAssignResponse::class,
        );
    }

    /**
     * @api
     *
     * Remove a phone number assignment from a 10DLC campaign.
     *
     * @param string $assignmentID phone number assignment ID
     * @param array{campaignID: string}|PhoneNumberUnassignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function unassign(
        string $assignmentID,
        array|PhoneNumberUnassignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PhoneNumberUnassignParams::parseRequest(
            $params,
            $requestOptions,
        );
        $campaignID = $parsed['campaignID'];
        unset($parsed['campaignID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/10dlc/campaigns/%1$s/phone-numbers/%2$s', $campaignID, $assignmentID,
            ],
            options: $options,
            convert: null,
        );
    }
}
