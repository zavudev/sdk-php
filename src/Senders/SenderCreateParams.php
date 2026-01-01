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
 *   phoneNumber: string,
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

    #[Required]
    public string $phoneNumber;

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
     * SenderCreateParams::with(name: ..., phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderCreateParams)->withName(...)->withPhoneNumber(...)
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
        string $phoneNumber,
        ?bool $setAsDefault = null,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['phoneNumber'] = $phoneNumber;

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
