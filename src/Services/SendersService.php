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
     * @param string $emailAddress From-address for the email channel (e.g. noreply@yourdomain.com). The address's domain must be a verified email domain in your project. Setting this attaches the email channel to the sender.
     * @param string $emailDomainID ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     * @param string $emailFromName display name shown in the recipient's inbox for the email channel
     * @param bool $emailReceivingEnabled Enable inbound email receiving on this sender. Requires a verified MX record on the domain; ignored otherwise.
     * @param bool $enableSMSOneway Enable the one-way SMS channel (`sms_oneway`). Needs nothing else — no phone number, no credential — so it is the fastest way to get a sender that can send. Recipients cannot reply. Confirm with `sms_oneway` in the `channels` array on the response.
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
        bool $enableSMSOneway = false,
        bool $enableVoice = false,
        ?string $phoneNumber = null,
        bool $setAsDefault = false,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): Sender {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'emailAddress' => $emailAddress,
                'emailDomainID' => $emailDomainID,
                'emailFromName' => $emailFromName,
                'emailReceivingEnabled' => $emailReceivingEnabled,
                'enableSMSOneway' => $enableSMSOneway,
                'enableVoice' => $enableVoice,
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
     * @param string $emailAddress Attach or change the sender's email from-address (e.g. noreply@yourdomain.com). The domain must be a verified email domain in your project.
     * @param bool $emailCatchAllEnabled Enable or disable domain catch-all. When enabled (with emailReceivingEnabled true), this sender receives email for any address at its domain. Ignored (treated as false) if receiving is not enabled.
     * @param string $emailDomainID ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     * @param string $emailFromName display name shown in the recipient's inbox for the email channel
     * @param bool $emailReceivingEnabled enable or disable inbound email receiving for this sender
     * @param bool $enableSMSOneway Turn the one-way SMS channel on or off. Enabling needs nothing else and takes effect immediately; disabling removes the channel from the sender. Confirm with the `channels` array on the response.
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
        ?bool $enableSMSOneway = null,
        ?bool $enableVoice = null,
        ?string $name = null,
        ?bool $setAsDefault = null,
        ?bool $webhookActive = null,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): Sender {
        $params = Util::removeNulls(
            [
                'emailAddress' => $emailAddress,
                'emailCatchAllEnabled' => $emailCatchAllEnabled,
                'emailDomainID' => $emailDomainID,
                'emailFromName' => $emailFromName,
                'emailReceivingEnabled' => $emailReceivingEnabled,
                'enableSMSOneway' => $enableSMSOneway,
                'enableVoice' => $enableVoice,
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
