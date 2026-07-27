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
     * @param string $emailAddress From-address for the email channel (e.g. noreply@yourdomain.com). The address's domain must be a verified email domain in your project. Setting this attaches the email channel to the sender.
     * @param string $emailDomainID ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     * @param string $emailFromName display name shown in the recipient's inbox for the email channel
     * @param bool $emailReceivingEnabled Enable inbound email receiving on this sender. Requires a verified MX record on the domain; ignored otherwise.
     * @param bool $enableVoice Let this sender place and answer phone calls. Requires `phoneNumber`; enabling it without one returns 400. Check the `channels` array on the response to confirm `voice` is on.
     * @param string $phoneNumber Phone number in E.164 format, and it must be a number your project already owns (see `GET /v1/phone-numbers`). The number is routed to the sender as part of this call, which is what turns the SMS channel on. Passing a number the project does not own, or one already attached to another sender, returns 400 rather than creating a sender that cannot send. Omit for an email-only sender.
     * @param list<WebhookEvent|value-of<WebhookEvent>> $webhookEvents events to subscribe to
     * @param string $webhookURL HTTPS URL for webhook events
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $emailAddress = null,
        ?string $emailDomainID = null,
        ?string $emailFromName = null,
        ?bool $emailReceivingEnabled = null,
        bool $enableVoice = false,
        ?string $phoneNumber = null,
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
     * @param string $emailAddress Attach or change the sender's email from-address (e.g. noreply@yourdomain.com). The domain must be a verified email domain in your project.
     * @param bool $emailCatchAllEnabled Enable or disable domain catch-all. When enabled (with emailReceivingEnabled true), this sender receives email for any address at its domain. Ignored (treated as false) if receiving is not enabled.
     * @param string $emailDomainID ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     * @param string $emailFromName display name shown in the recipient's inbox for the email channel
     * @param bool $emailReceivingEnabled enable or disable inbound email receiving for this sender
     * @param bool $enableVoice Turn the voice channel on or off. The sender must already have a phone number provisioned for calls; enabling it otherwise returns 400 instead of storing a flag that changes nothing. Confirm with the `channels` array on the response.
     * @param bool $webhookActive whether the webhook is active
     * @param list<WebhookEvent|value-of<WebhookEvent>> $webhookEvents events to subscribe to
     * @param string|null $webhookURL HTTPS URL for webhook events. Set to null to remove webhook.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        ?string $emailAddress = null,
        ?bool $emailCatchAllEnabled = null,
        ?string $emailDomainID = null,
        ?string $emailFromName = null,
        ?bool $emailReceivingEnabled = null,
        ?bool $enableVoice = null,
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
