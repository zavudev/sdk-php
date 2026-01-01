<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
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

interface SendersContract
{
    /**
     * @api
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
    ): Sender;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): Sender;

    /**
     * @api
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
    ): Sender;

    /**
     * @api
     *
     * @return Cursor<Sender>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): WhatsappBusinessProfileResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): WebhookSecretResponse;

    /**
     * @api
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
    ): SenderUpdateProfileResponse;

    /**
     * @api
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
    ): SenderUploadProfilePictureResponse;
}
