<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc\Campaigns;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignParams;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberAssignResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberListResponse;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\PhoneNumberUnassignParams;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface PhoneNumbersRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param array<string,mixed>|PhoneNumberAssignParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $assignmentID phone number assignment ID
     * @param array<string,mixed>|PhoneNumberUnassignParams $params
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
    ): BaseResponse;
}
