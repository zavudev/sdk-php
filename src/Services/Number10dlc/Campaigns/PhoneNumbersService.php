<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc\Campaigns;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberListResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Number10dlc\Campaigns\PhoneNumbersContract;

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
     * List phone numbers assigned to a 10DLC campaign.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): PhoneNumberListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($campaignID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Assign a US phone number to an approved 10DLC campaign. The campaign must be in approved status.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param string $phoneNumberID ID of the phone number to assign
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function assign(
        string $campaignID,
        string $phoneNumberID,
        RequestOptions|array|null $requestOptions = null,
    ): PhoneNumberAssignResponse {
        $params = Util::removeNulls(['phoneNumberID' => $phoneNumberID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->assign($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a phone number assignment from a 10DLC campaign.
     *
     * @param string $assignmentID phone number assignment ID
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unassign(
        string $assignmentID,
        string $campaignID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['campaignID' => $campaignID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unassign($assignmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
