<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Sender;
use Zavudev\Senders\SenderUpdateProfileResponse;
use Zavudev\Senders\SenderUploadProfilePictureParams\MimeType;
use Zavudev\Senders\SenderUploadProfilePictureResponse;
use Zavudev\Senders\WebhookEvent;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\Senders\WhatsappBusinessProfileResponse;
use Zavudev\Senders\WhatsappBusinessProfileVertical;
use Zavudev\ServiceContracts\SendersContract;
use Zavudev\Services\Senders\AgentService;
use Zavudev\Services\Senders\WhatsappSyncService;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SendersService implements SendersContract
{
    /**
     * @api
     */
    public SendersRawService $raw;

    /**
     * @api
     */
    public AgentService $agent;

    /**
     * @api
     */
    public WhatsappSyncService $whatsappSync;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SendersRawService($client);
        $this->agent = new AgentService($client);
        $this->whatsappSync = new WhatsappSyncService($client);
    }

    /**
     * @api
     *
     * Create sender
     *
     * @param list<WebhookEvent|value-of<WebhookEvent>> $webhookEvents events to subscribe to
     * @param string $webhookURL HTTPS URL for webhook events
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $phoneNumber,
        bool $setAsDefault = false,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): Sender {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'phoneNumber' => $phoneNumber,
                'setAsDefault' => $setAsDefault,
                'webhookEvents' => $webhookEvents,
                'webhookURL' => $webhookURL,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get sender
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): Sender {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update sender
     *
     * @param bool $emailReceivingEnabled enable or disable inbound email receiving for this sender
     * @param bool $webhookActive whether the webhook is active
     * @param list<WebhookEvent|value-of<WebhookEvent>> $webhookEvents events to subscribe to
     * @param string|null $webhookURL HTTPS URL for webhook events. Set to null to remove webhook.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        ?bool $emailReceivingEnabled = null,
        ?string $name = null,
        ?bool $setAsDefault = null,
        ?bool $webhookActive = null,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): Sender {
        $params = Util::removeNulls(
            [
                'emailReceivingEnabled' => $emailReceivingEnabled,
                'name' => $name,
                'setAsDefault' => $setAsDefault,
                'webhookActive' => $webhookActive,
                'webhookEvents' => $webhookEvents,
                'webhookURL' => $webhookURL,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List senders
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Sender>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete sender
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get the WhatsApp Business profile for a sender. The sender must have a WhatsApp Business Account connected.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappBusinessProfileResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getProfile($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Regenerate the webhook secret for a sender. The old secret will be invalidated immediately.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WebhookSecretResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->regenerateWebhookSecret($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update the WhatsApp Business profile for a sender. The sender must have a WhatsApp Business Account connected.
     *
     * @param string $about short description of the business (max 139 characters)
     * @param string $address physical address of the business (max 256 characters)
     * @param string $description extended description of the business (max 512 characters)
     * @param string $email business email address
     * @param WhatsappBusinessProfileVertical|value-of<WhatsappBusinessProfileVertical> $vertical business category for WhatsApp Business profile
     * @param list<string> $websites business website URLs (maximum 2)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateProfile(
        string $senderID,
        ?string $about = null,
        ?string $address = null,
        ?string $description = null,
        ?string $email = null,
        WhatsappBusinessProfileVertical|string|null $vertical = null,
        ?array $websites = null,
        RequestOptions|array|null $requestOptions = null,
    ): SenderUpdateProfileResponse {
        $params = Util::removeNulls(
            [
                'about' => $about,
                'address' => $address,
                'description' => $description,
                'email' => $email,
                'vertical' => $vertical,
                'websites' => $websites,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateProfile($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Upload a new profile picture for the WhatsApp Business profile. The image will be uploaded to Meta and set as the profile picture.
     *
     * @param string $imageURL URL of the image to upload
     * @param MimeType|value-of<MimeType> $mimeType MIME type of the image
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function uploadProfilePicture(
        string $senderID,
        string $imageURL,
        MimeType|string $mimeType,
        RequestOptions|array|null $requestOptions = null,
    ): SenderUploadProfilePictureResponse {
        $params = Util::removeNulls(
            ['imageURL' => $imageURL, 'mimeType' => $mimeType]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->uploadProfilePicture($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
