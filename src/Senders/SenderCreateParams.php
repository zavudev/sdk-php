<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

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
 *   phoneNumber?: string|null,
 *   setAsDefault?: bool|null,
 *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>|null,
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
     * Phone number in E.164 format. Required for phone-based channels (SMS, WhatsApp). Omit for an email-only sender.
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
     */
    public static function with(
        string $name,
        ?string $emailAddress = null,
        ?string $emailDomainID = null,
        ?string $emailFromName = null,
        ?bool $emailReceivingEnabled = null,
        ?string $phoneNumber = null,
        ?bool $setAsDefault = null,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $emailAddress && $self['emailAddress'] = $emailAddress;
        null !== $emailDomainID && $self['emailDomainID'] = $emailDomainID;
        null !== $emailFromName && $self['emailFromName'] = $emailFromName;
        null !== $emailReceivingEnabled && $self['emailReceivingEnabled'] = $emailReceivingEnabled;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $setAsDefault && $self['setAsDefault'] = $setAsDefault;
        null !== $webhookEvents && $self['webhookEvents'] = $webhookEvents;
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
     * Phone number in E.164 format. Required for phone-based channels (SMS, WhatsApp). Omit for an email-only sender.
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
     * HTTPS URL for webhook events.
     */
    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
