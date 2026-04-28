<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
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
use Zavudev\ServiceContracts\Number10dlc\CampaignsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class CampaignsRawService implements CampaignsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a 10DLC campaign under an existing brand. The campaign starts in draft status. Submit it for carrier review using the submit endpoint.
     *
     * @param array{
     *   affiliateMarketing: bool,
     *   ageGated: bool,
     *   brandID: string,
     *   description: string,
     *   directLending: bool,
     *   embeddedLink: bool,
     *   embeddedPhone: bool,
     *   name: string,
     *   numberPooling: bool,
     *   sampleMessages: list<string>,
     *   subscriberHelp: bool,
     *   subscriberOptIn: bool,
     *   subscriberOptOut: bool,
     *   useCase: string,
     *   helpMessage?: string,
     *   messageFlow?: string,
     *   optInKeywords?: list<string>,
     *   optOutKeywords?: list<string>,
     *   subUseCases?: list<string>,
     * }|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CampaignCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/10dlc/campaigns',
            body: (object) $parsed,
            options: $options,
            convert: CampaignNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get 10DLC campaign
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/10dlc/campaigns/%1$s', $campaignID],
            options: $requestOptions,
            convert: CampaignGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a 10DLC campaign in draft status. Cannot update after submission.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param array{
     *   description?: string,
     *   helpMessage?: string,
     *   messageFlow?: string,
     *   name?: string,
     *   optInKeywords?: list<string>,
     *   optOutKeywords?: list<string>,
     *   sampleMessages?: list<string>,
     * }|CampaignUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CampaignUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/10dlc/campaigns/%1$s', $campaignID],
            body: (object) $parsed,
            options: $options,
            convert: CampaignUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List 10DLC campaign registrations for this project.
     *
     * @param array{
     *   brandID?: string, cursor?: string, limit?: int
     * }|CampaignListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<TenDlcCampaign>>
     *
     * @throws APIException
     */
    public function list(
        array|CampaignListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/10dlc/campaigns',
            query: Util::array_transform_keys($parsed, ['brandID' => 'brandId']),
            options: $options,
            convert: TenDlcCampaign::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete 10DLC campaign
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/10dlc/campaigns/%1$s', $campaignID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Submit a draft campaign for carrier review. The campaign must be in draft status and its brand must be verified.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/10dlc/campaigns/%1$s/submit', $campaignID],
            options: $requestOptions,
            convert: CampaignSubmitResponse::class,
        );
    }

    /**
     * @api
     *
     * Sync the campaign status with the registration provider. Use this to check for approval updates after submission.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/10dlc/campaigns/%1$s/sync', $campaignID],
            options: $requestOptions,
            convert: CampaignSyncStatusResponse::class,
        );
    }
}
