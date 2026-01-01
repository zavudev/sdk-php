<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update sender.
 *
 * @see Zavudev\Services\SendersService::update()
 *
 * @phpstan-type SenderUpdateParamsShape = array{
 *   emailReceivingEnabled?: bool|null,
 *   name?: string|null,
 *   setAsDefault?: bool|null,
 *   webhookActive?: bool|null,
 *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>|null,
 *   webhookURL?: string|null,
 * }
 */
final class SenderUpdateParams implements BaseModel
{
    /** @use SdkModel<SenderUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Enable or disable inbound email receiving for this sender.
     */
    #[Optional]
    public ?bool $emailReceivingEnabled;

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
     */
    public static function with(
        ?bool $emailReceivingEnabled = null,
        ?string $name = null,
        ?bool $setAsDefault = null,
        ?bool $webhookActive = null,
        ?array $webhookEvents = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        null !== $emailReceivingEnabled && $self['emailReceivingEnabled'] = $emailReceivingEnabled;
        null !== $name && $self['name'] = $name;
        null !== $setAsDefault && $self['setAsDefault'] = $setAsDefault;
        null !== $webhookActive && $self['webhookActive'] = $webhookActive;
        null !== $webhookEvents && $self['webhookEvents'] = $webhookEvents;
        null !== $webhookURL && $self['webhookURL'] = $webhookURL;

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
     * HTTPS URL for webhook events. Set to null to remove webhook.
     */
    public function withWebhookURL(?string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
