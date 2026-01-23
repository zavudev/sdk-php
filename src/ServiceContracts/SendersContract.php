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

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SendersContract
{
    /**
     * @api
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
    ): Sender;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): Sender;

    /**
     * @api
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
    ): Sender;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WhatsappBusinessProfileResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): WebhookSecretResponse;

    /**
     * @api
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
    ): SenderUpdateProfileResponse;

    /**
     * @api
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
    ): SenderUploadProfilePictureResponse;
}
