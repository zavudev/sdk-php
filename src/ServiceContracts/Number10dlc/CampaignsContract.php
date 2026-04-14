<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Number10dlc;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Campaigns\CampaignGetResponse;
use Zavudev\Number10dlc\Campaigns\CampaignNewResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSubmitResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSyncStatusResponse;
use Zavudev\Number10dlc\Campaigns\CampaignUpdateResponse;
use Zavudev\Number10dlc\Campaigns\TenDlcCampaign;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface CampaignsContract
{
    /**
     * @api
     *
     * @param string $brandID ID of the brand to create this campaign under
     * @param list<string> $sampleMessages
     * @param string $useCase Campaign use case (e.g., ACCOUNT_NOTIFICATION, MARKETING, 2FA).
     * @param list<string> $optInKeywords
     * @param list<string> $optOutKeywords
     * @param list<string> $subUseCases
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        bool $affiliateMarketing,
        bool $ageGated,
        string $brandID,
        string $description,
        bool $directLending,
        bool $embeddedLink,
        bool $embeddedPhone,
        string $name,
        bool $numberPooling,
        array $sampleMessages,
        bool $subscriberHelp,
        bool $subscriberOptIn,
        bool $subscriberOptOut,
        string $useCase,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?array $optInKeywords = null,
        ?array $optOutKeywords = null,
        ?array $subUseCases = null,
        RequestOptions|array|null $requestOptions = null,
    ): CampaignNewResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignGetResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param list<string> $optInKeywords
     * @param list<string> $optOutKeywords
     * @param list<string> $sampleMessages
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        ?string $description = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?string $name = null,
        ?array $optInKeywords = null,
        ?array $optOutKeywords = null,
        ?array $sampleMessages = null,
        RequestOptions|array|null $requestOptions = null,
    ): CampaignUpdateResponse;

    /**
     * @api
     *
     * @param string $brandID filter campaigns by brand ID
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<TenDlcCampaign>
     *
     * @throws APIException
     */
    public function list(
        ?string $brandID = null,
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignSubmitResponse;

    /**
     * @api
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function syncStatus(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignSyncStatusResponse;
}
