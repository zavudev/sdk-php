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
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SendersRawService($client);
        $this->agent = new AgentService($client);
    }

    /**
     * @api
     *
     * Create sender
     *
     * @param list<'message.queued'|'message.sent'|'message.delivered'|'message.failed'|'message.inbound'|'message.unsupported'|'conversation.new'|'template.status_changed'|WebhookEvent> $webhookEvents Events to subscribe to.
     * @param string $webhookURL HTTPS URL for webhook events
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $phoneNumber,
        bool $setAsDefault = false,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
        ?RequestOptions $requestOptions = null,
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
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @param list<'message.queued'|'message.sent'|'message.delivered'|'message.failed'|'message.inbound'|'message.unsupported'|'conversation.new'|'template.status_changed'|WebhookEvent> $webhookEvents Events to subscribe to.
     * @param string|null $webhookURL HTTPS URL for webhook events. Set to null to remove webhook.
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
        ?RequestOptions $requestOptions = null,
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
     * @return Cursor<Sender>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
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
     * @throws APIException
     */
    public function delete(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @param 'UNDEFINED'|'OTHER'|'AUTO'|'BEAUTY'|'APPAREL'|'EDU'|'ENTERTAIN'|'EVENT_PLAN'|'FINANCE'|'GROCERY'|'GOVT'|'HOTEL'|'HEALTH'|'NONPROFIT'|'PROF_SERVICES'|'RETAIL'|'TRAVEL'|'RESTAURANT'|'NOT_A_BIZ'|WhatsappBusinessProfileVertical $vertical business category for WhatsApp Business profile
     * @param list<string> $websites business website URLs (maximum 2)
     *
     * @throws APIException
     */
    public function updateProfile(
        string $senderID,
        ?string $about = null,
        ?string $address = null,
        ?string $description = null,
        ?string $email = null,
        string|WhatsappBusinessProfileVertical|null $vertical = null,
        ?array $websites = null,
        ?RequestOptions $requestOptions = null,
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
     * @param 'image/jpeg'|'image/png'|MimeType $mimeType MIME type of the image
     *
     * @throws APIException
     */
    public function uploadProfilePicture(
        string $senderID,
        string $imageURL,
        string|MimeType $mimeType,
        ?RequestOptions $requestOptions = null,
    ): SenderUploadProfilePictureResponse {
        $params = Util::removeNulls(
            ['imageURL' => $imageURL, 'mimeType' => $mimeType]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->uploadProfilePicture($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
