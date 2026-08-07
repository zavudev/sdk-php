<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\SenderUpdateParams\WebhookSignatureVersion;

/**
 * Update sender.
 *
 * @see Zavudev\Services\SendersService::update()
 *
 * @phpstan-type SenderUpdateParamsShape = array{
 *   emailAddress?: string|null,
 *   emailCatchAllEnabled?: bool|null,
 *   emailDomainID?: string|null,
 *   emailFromName?: string|null,
 *   emailReceivingEnabled?: bool|null,
 *   enableSMSOneway?: bool|null,
 *   enableVoice?: bool|null,
 *   name?: string|null,
 *   setAsDefault?: bool|null,
 *   webhookActive?: bool|null,
 *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>|null,
 *   webhookSignatureVersion?: null|WebhookSignatureVersion|value-of<WebhookSignatureVersion>,
 *   webhookURL?: string|null,
 * }
 */
final class SenderUpdateParams implements BaseModel
{
    /** @use SdkModel<SenderUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Attach or change the sender's email from-address (e.g. noreply@yourdomain.com). The domain must be a verified email domain in your project.
     */
    #[Optional]
    public ?string $emailAddress;

    /**
     * Enable or disable domain catch-all. When enabled (with emailReceivingEnabled true), this sender receives email for any address at its domain. Ignored (treated as false) if receiving is not enabled.
     */
    #[Optional]
    public ?bool $emailCatchAllEnabled;

    /**
     * ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     */
    #[Optional('emailDomainId')]
    public ?string $emailDomainID;

    /**
     * Display name shown in the recipient's inbox for the email channel.
     */
    #[Optional]
    public ?string $emailFromName;

    /**
     * Enable or disable inbound email receiving for this sender.
     */
    #[Optional]
    public ?bool $emailReceivingEnabled;

    /**
     * Turn the one-way SMS channel on or off. Enabling needs nothing else and takes effect immediately; disabling removes the channel from the sender. Confirm with the `channels` array on the response.
     */
    #[Optional('enableSmsOneway')]
    public ?bool $enableSMSOneway;

    /**
     * Turn the voice channel on or off. The sender must already have a phone number provisioned for calls; enabling it otherwise returns 400 instead of storing a flag that changes nothing. Confirm with the `channels` array on the response.
     */
    #[Optional]
    public ?bool $enableVoice;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?bool $setAsDefault;

    /**
     * Whether the webhook is active.
     */
    #[Optional]
    public ?bool $webhookActive;

    /**
     * Events to subscribe to.
     *
     * @var list<value-of<WebhookEvent>>|null $webhookEvents
     */
    #[Optional(list: WebhookEvent::class)]
    public ?array $webhookEvents;

    /**
     * Which `X-Zavu-Signature` scheme this receiver is sent.
     *
     * - `v1`: `v1=HMAC_SHA256(secret, body)`. The scheme used before this was configurable. Existing webhooks stay on it until you move them.
     * - `v2`: `v2=HMAC_SHA256(secret, "{t}.{body}")`. The current scheme, and the default for new senders. It signs the timestamp together with the body.
     * - `v1+v2`: both signatures, sharing one `t`. The migration setting: a receiver reading either one works, so you can deploy and confirm your new verifier before switching over.
     *
     * Moving from `v1` straight to `v2` returns `400`. Set `v1+v2` first. See https://docs.zavu.dev/guides/receiving-messages/signature-migration
     *
     * @var value-of<WebhookSignatureVersion>|null $webhookSignatureVersion
     */
    #[Optional(enum: WebhookSignatureVersion::class)]
    public ?string $webhookSignatureVersion;

    /**
     * HTTPS URL for webhook events. Set to null to remove webhook.
     */
    #[Optional('webhookUrl', nullable: true)]
    public ?string $webhookURL;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<WebhookEvent|value-of<WebhookEvent>>|null $webhookEvents
     * @param WebhookSignatureVersion|value-of<WebhookSignatureVersion>|null $webhookSignatureVersion
     */
    public static function with(
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
        WebhookSignatureVersion|string|null $webhookSignatureVersion = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        null !== $emailAddress && $self['emailAddress'] = $emailAddress;
        null !== $emailCatchAllEnabled && $self['emailCatchAllEnabled'] = $emailCatchAllEnabled;
        null !== $emailDomainID && $self['emailDomainID'] = $emailDomainID;
        null !== $emailFromName && $self['emailFromName'] = $emailFromName;
        null !== $emailReceivingEnabled && $self['emailReceivingEnabled'] = $emailReceivingEnabled;
        null !== $enableSMSOneway && $self['enableSMSOneway'] = $enableSMSOneway;
        null !== $enableVoice && $self['enableVoice'] = $enableVoice;
        null !== $name && $self['name'] = $name;
        null !== $setAsDefault && $self['setAsDefault'] = $setAsDefault;
        null !== $webhookActive && $self['webhookActive'] = $webhookActive;
        null !== $webhookEvents && $self['webhookEvents'] = $webhookEvents;
        null !== $webhookSignatureVersion && $self['webhookSignatureVersion'] = $webhookSignatureVersion;
        null !== $webhookURL && $self['webhookURL'] = $webhookURL;

        return $self;
    }

    /**
     * Attach or change the sender's email from-address (e.g. noreply@yourdomain.com). The domain must be a verified email domain in your project.
     */
    public function withEmailAddress(string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * Enable or disable domain catch-all. When enabled (with emailReceivingEnabled true), this sender receives email for any address at its domain. Ignored (treated as false) if receiving is not enabled.
     */
    public function withEmailCatchAllEnabled(bool $emailCatchAllEnabled): self
    {
        $self = clone $this;
        $self['emailCatchAllEnabled'] = $emailCatchAllEnabled;

        return $self;
    }

    /**
     * ID of the verified email domain to attach. Optional — resolved from `emailAddress`'s domain when omitted.
     */
    public function withEmailDomainID(string $emailDomainID): self
    {
        $self = clone $this;
        $self['emailDomainID'] = $emailDomainID;

        return $self;
    }

    /**
     * Display name shown in the recipient's inbox for the email channel.
     */
    public function withEmailFromName(string $emailFromName): self
    {
        $self = clone $this;
        $self['emailFromName'] = $emailFromName;

        return $self;
    }

    /**
     * Enable or disable inbound email receiving for this sender.
     */
    public function withEmailReceivingEnabled(bool $emailReceivingEnabled): self
    {
        $self = clone $this;
        $self['emailReceivingEnabled'] = $emailReceivingEnabled;

        return $self;
    }

    /**
     * Turn the one-way SMS channel on or off. Enabling needs nothing else and takes effect immediately; disabling removes the channel from the sender. Confirm with the `channels` array on the response.
     */
    public function withEnableSMSOneway(bool $enableSMSOneway): self
    {
        $self = clone $this;
        $self['enableSMSOneway'] = $enableSMSOneway;

        return $self;
    }

    /**
     * Turn the voice channel on or off. The sender must already have a phone number provisioned for calls; enabling it otherwise returns 400 instead of storing a flag that changes nothing. Confirm with the `channels` array on the response.
     */
    public function withEnableVoice(bool $enableVoice): self
    {
        $self = clone $this;
        $self['enableVoice'] = $enableVoice;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withSetAsDefault(bool $setAsDefault): self
    {
        $self = clone $this;
        $self['setAsDefault'] = $setAsDefault;

        return $self;
    }

    /**
     * Whether the webhook is active.
     */
    public function withWebhookActive(bool $webhookActive): self
    {
        $self = clone $this;
        $self['webhookActive'] = $webhookActive;

        return $self;
    }

    /**
     * Events to subscribe to.
     *
     * @param list<WebhookEvent|value-of<WebhookEvent>> $webhookEvents
     */
    public function withWebhookEvents(array $webhookEvents): self
    {
        $self = clone $this;
        $self['webhookEvents'] = $webhookEvents;

        return $self;
    }

    /**
     * Which `X-Zavu-Signature` scheme this receiver is sent.
     *
     * - `v1`: `v1=HMAC_SHA256(secret, body)`. The scheme used before this was configurable. Existing webhooks stay on it until you move them.
     * - `v2`: `v2=HMAC_SHA256(secret, "{t}.{body}")`. The current scheme, and the default for new senders. It signs the timestamp together with the body.
     * - `v1+v2`: both signatures, sharing one `t`. The migration setting: a receiver reading either one works, so you can deploy and confirm your new verifier before switching over.
     *
     * Moving from `v1` straight to `v2` returns `400`. Set `v1+v2` first. See https://docs.zavu.dev/guides/receiving-messages/signature-migration
     *
     * @param WebhookSignatureVersion|value-of<WebhookSignatureVersion> $webhookSignatureVersion
     */
    public function withWebhookSignatureVersion(
        WebhookSignatureVersion|string $webhookSignatureVersion
    ): self {
        $self = clone $this;
        $self['webhookSignatureVersion'] = $webhookSignatureVersion;

        return $self;
    }

    /**
     * HTTPS URL for webhook events. Set to null to remove webhook.
     */
    public function withWebhookURL(?string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
