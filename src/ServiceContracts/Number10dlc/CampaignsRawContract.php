<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Campaigns\CampaignCreateParams;
use Zavudev\Number10dlc\Campaigns\CampaignGetResponse;
use Zavudev\Number10dlc\Campaigns\CampaignListParams;
use Zavudev\Number10dlc\Campaigns\CampaignNewResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSubmitResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSyncStatusResponse;
use Zavudev\Number10dlc\Campaigns\CampaignUpdateParams;
use Zavudev\Number10dlc\Campaigns\CampaignUpdateResponse;
use Zavudev\Number10dlc\Campaigns\TenDlcCampaign;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface CampaignsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CampaignCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param array<string,mixed>|CampaignUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        array|CampaignUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CampaignListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<TenDlcCampaign>>
     *
     * @throws APIException
     */
    public function list(
        array|CampaignListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignSubmitResponse>
     *
     * @throws APIException
     */
    public function submit(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignSyncStatusResponse>
     *
     * @throws APIException
     */
    public function syncStatus(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
