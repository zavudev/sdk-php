<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc\Campaigns;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberListResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface PhoneNumbersContract
{
    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): PhoneNumberListResponse;

    /**
     * @api
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
    ): PhoneNumberAssignResponse;

    /**
     * @api
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
    ): mixed;
}
