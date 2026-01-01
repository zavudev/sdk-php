<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Webhook configuration for the sender.
 *
 * @phpstan-type SenderWebhookShape = array{
 *   active: bool,
 *   events: list<WebhookEvent|value-of<WebhookEvent>>,
 *   url: string,
 *   secret?: string|null,
 * }
 */
final class SenderWebhook implements BaseModel
{
    /** @use SdkModel<SenderWebhookShape> */
    use SdkModel;

    /**
     * Whether the webhook is active.
     */
    #[Required]
    public bool $active;

    /**
     * List of events the webhook is subscribed to.
     *
     * @var list<value-of<WebhookEvent>> $events
     */
    #[Required(list: WebhookEvent::class)]
    public array $events;

    /**
     * HTTPS URL that will receive webhook events.
     */
    #[Required]
    public string $url;

    /**
     * Webhook secret for signature verification. Only returned on create or regenerate.
     */
    #[Optional]
    public ?string $secret;

    /**
     * `new SenderWebhook()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderWebhook::with(active: ..., events: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderWebhook)->withActive(...)->withEvents(...)->withURL(...)
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
     * @param list<WebhookEvent|value-of<WebhookEvent>> $events
     */
    public static function with(
        array $events,
        string $url,
        bool $active = true,
        ?string $secret = null
    ): self {
        $self = new self;

        $self['active'] = $active;
        $self['events'] = $events;
        $self['url'] = $url;

        null !== $secret && $self['secret'] = $secret;

        return $self;
    }

    /**
     * Whether the webhook is active.
     */
    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    /**
     * List of events the webhook is subscribed to.
     *
     * @param list<WebhookEvent|value-of<WebhookEvent>> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    /**
     * HTTPS URL that will receive webhook events.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Webhook secret for signature verification. Only returned on create or regenerate.
     */
    public function withSecret(string $secret): self
    {
        $self = clone $this;
        $self['secret'] = $secret;

        return $self;
    }
}
