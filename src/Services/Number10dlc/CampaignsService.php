<?php

declare(strict_types=1);

namespace Zavudev\Services\Number10dlc;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Number10dlc\Campaigns\CampaignGetResponse;
use Zavudev\Number10dlc\Campaigns\CampaignNewResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSubmitResponse;
use Zavudev\Number10dlc\Campaigns\CampaignSyncStatusResponse;
use Zavudev\Number10dlc\Campaigns\CampaignUpdateResponse;
use Zavudev\Number10dlc\Campaigns\TenDlcCampaign;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Number10dlc\CampaignsContract;
use Zavudev\Services\Number10dlc\Campaigns\PhoneNumbersService;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class CampaignsService implements CampaignsContract
{
    /**
     * @api
     */
    public CampaignsRawService $raw;

    /**
     * @api
     */
    public PhoneNumbersService $phoneNumbers;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CampaignsRawService($client);
        $this->phoneNumbers = new PhoneNumbersService($client);
    }

    /**
     * @api
     *
     * Create a 10DLC campaign under an existing brand. The campaign starts in draft status. Submit it for carrier review using the submit endpoint.
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
    ): CampaignNewResponse {
        $params = Util::removeNulls(
            [
                'affiliateMarketing' => $affiliateMarketing,
                'ageGated' => $ageGated,
                'brandID' => $brandID,
                'description' => $description,
                'directLending' => $directLending,
                'embeddedLink' => $embeddedLink,
                'embeddedPhone' => $embeddedPhone,
                'name' => $name,
                'numberPooling' => $numberPooling,
                'sampleMessages' => $sampleMessages,
                'subscriberHelp' => $subscriberHelp,
                'subscriberOptIn' => $subscriberOptIn,
                'subscriberOptOut' => $subscriberOptOut,
                'useCase' => $useCase,
                'helpMessage' => $helpMessage,
                'messageFlow' => $messageFlow,
                'optInKeywords' => $optInKeywords,
                'optOutKeywords' => $optOutKeywords,
                'subUseCases' => $subUseCases,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get 10DLC campaign
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($campaignID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a 10DLC campaign in draft status. Cannot update after submission.
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
    ): CampaignUpdateResponse {
        $params = Util::removeNulls(
            [
                'description' => $description,
                'helpMessage' => $helpMessage,
                'messageFlow' => $messageFlow,
                'name' => $name,
                'optInKeywords' => $optInKeywords,
                'optOutKeywords' => $optOutKeywords,
                'sampleMessages' => $sampleMessages,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List 10DLC campaign registrations for this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['brandID' => $brandID, 'cursor' => $cursor, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete 10DLC campaign
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($campaignID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Submit a draft campaign for carrier review. The campaign must be in draft status and its brand must be verified.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignSubmitResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->submit($campaignID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sync the campaign status with the registration provider. Use this to check for approval updates after submission.
     *
     * @param string $campaignID 10DLC campaign ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function syncStatus(
        string $campaignID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignSyncStatusResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->syncStatus($campaignID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
