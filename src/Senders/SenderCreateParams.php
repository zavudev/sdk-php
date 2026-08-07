<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\SenderCreateParams\WebhookSignatureVersion;

/**
 * Create sender.
 *
 * @see Zavudev\Services\SendersService::create()
 *
 * @phpstan-type SenderCreateParamsShape = array{
 *   name: string,
 *   emailAddress?: string|null,
 *   emailDomainID?: string|null,
 *   emailFromName?: string|null,
 *   emailReceivingEnabled?: bool|null,
 *   enableSMSOneway?: bool|null,
 *   enableVoice?: bool|null,
 *   phoneNumber?: string|null,
 *   setAsDefault?: bool|null,
 *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>|null,
 *   webhookSignatureVersion?: null|WebhookSignatureVersion|value-of<WebhookSignatureVersion>,
 *   webhookURL?: string|null,
 * }
 */
final class SenderCreateParams implements BaseModel
{
    /** @use SdkModel<SenderCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    /**
     * From-address for the email channel (e.g. noreply@yourdomain.com). The address's domain must be a verified email domain in your project. Setting this attaches the email channel to the sender.
     */
    #[Optional]
    public ?string $emailAddress;

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
     * Enable inbound email receiving on this sender. Requires a verified MX record on the domain; ignored otherwise.
     */
    #[Optional]
    public ?bool $emailReceivingEnabled;

    /**
     * Enable the one-way SMS channel (`sms_oneway`). Needs nothing else — no phone number, no credential — so it is the fastest way to get a sender that can send. Recipients cannot reply. Confirm with `sms_oneway` in the `channels` array on the response.
     */
    #[Optional('enableSmsOneway')]
    public ?bool $enableSMSOneway;

    /**
     * Let this sender place and answer phone calls. Requires `phoneNumber`; enabling it without one returns 400. Check the `channels` array on the response to confirm `voice` is on.
     */
    #[Optional]
    public ?bool $enableVoice;

    /**
     * Phone number in E.164 format, and it must be a number your project already owns (see `GET /v1/phone-numbers`). The number is routed to the sender as part of this call, which is what turns the SMS channel on. Passing a number the project does not own, or one already attached to another sender, returns 400 rather than creating a sender that cannot send. Omit for an email-only sender.
     */
    #[Optional]
    public ?string $phoneNumber;

    #[Optional]
    public ?bool $setAsDefault;

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
     * HTTPS URL for webhook events.
     */
    #[Optional('webhookUrl')]
    public ?string $webhookURL;

    /**
     * `new SenderCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderCreateParams)->withName(...)
     * ```
     */
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
        string $name,
        ?string $emailAddress = null,
        ?string $emailDomainID = null,
        ?string $emailFromName = null,
        ?bool $emailReceivingEnabled = null,
        ?bool $enableSMSOneway = null,
        ?bool $enableVoice = null,
        ?string $phoneNumber = null,
        ?bool $setAsDefault = null,
        ?array $webhookEvents = null,
        WebhookSignatureVersion|string|null $webhookSignatureVersion = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $emailAddress && $self['emailAddress'] = $emailAddress;
        null !== $emailDomainID && $self['emailDomainID'] = $emailDomainID;
        null !== $emailFromName && $self['emailFromName'] = $emailFromName;
        null !== $emailReceivingEnabled && $self['emailReceivingEnabled'] = $emailReceivingEnabled;
        null !== $enableSMSOneway && $self['enableSMSOneway'] = $enableSMSOneway;
        null !== $enableVoice && $self['enableVoice'] = $enableVoice;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $setAsDefault && $self['setAsDefault'] = $setAsDefault;
        null !== $webhookEvents && $self['webhookEvents'] = $webhookEvents;
        null !== $webhookSignatureVersion && $self['webhookSignatureVersion'] = $webhookSignatureVersion;
        null !== $webhookURL && $self['webhookURL'] = $webhookURL;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * From-address for the email channel (e.g. noreply@yourdomain.com). The address's domain must be a verified email domain in your project. Setting this attaches the email channel to the sender.
     */
    public function withEmailAddress(string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

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
     * Enable inbound email receiving on this sender. Requires a verified MX record on the domain; ignored otherwise.
     */
    public function withEmailReceivingEnabled(bool $emailReceivingEnabled): self
    {
        $self = clone $this;
        $self['emailReceivingEnabled'] = $emailReceivingEnabled;

        return $self;
    }

    /**
     * Enable the one-way SMS channel (`sms_oneway`). Needs nothing else — no phone number, no credential — so it is the fastest way to get a sender that can send. Recipients cannot reply. Confirm with `sms_oneway` in the `channels` array on the response.
     */
    public function withEnableSMSOneway(bool $enableSMSOneway): self
    {
        $self = clone $this;
        $self['enableSMSOneway'] = $enableSMSOneway;

        return $self;
    }

    /**
     * Let this sender place and answer phone calls. Requires `phoneNumber`; enabling it without one returns 400. Check the `channels` array on the response to confirm `voice` is on.
     */
    public function withEnableVoice(bool $enableVoice): self
    {
        $self = clone $this;
        $self['enableVoice'] = $enableVoice;

        return $self;
    }

    /**
     * Phone number in E.164 format, and it must be a number your project already owns (see `GET /v1/phone-numbers`). The number is routed to the sender as part of this call, which is what turns the SMS channel on. Passing a number the project does not own, or one already attached to another sender, returns 400 rather than creating a sender that cannot send. Omit for an email-only sender.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withSetAsDefault(bool $setAsDefault): self
    {
        $self = clone $this;
        $self['setAsDefault'] = $setAsDefault;

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
     * HTTPS URL for webhook events.
     */
    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
