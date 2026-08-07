<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\SenderWebhook\SignatureVersion;

/**
 * Webhook configuration for the sender.
 *
 * @phpstan-type SenderWebhookShape = array{
 *   active: bool,
 *   events: list<WebhookEvent|value-of<WebhookEvent>>,
 *   signatureVersion: SignatureVersion|value-of<SignatureVersion>,
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
     * Which `X-Zavu-Signature` scheme this receiver is sent.
     *
     * - `v1`: `v1=HMAC_SHA256(secret, body)`. The scheme used before this was configurable. Existing webhooks stay on it until you move them.
     * - `v2`: `v2=HMAC_SHA256(secret, "{t}.{body}")`. The current scheme, and the default for new senders. It signs the timestamp together with the body.
     * - `v1+v2`: both signatures, sharing one `t`. The migration setting: a receiver reading either one works, so you can deploy and confirm your new verifier before switching over.
     *
     * Moving from `v1` straight to `v2` returns `400`. Set `v1+v2` first. See https://docs.zavu.dev/guides/receiving-messages/signature-migration
     *
     * @var value-of<SignatureVersion> $signatureVersion
     */
    #[Required(enum: SignatureVersion::class)]
    public string $signatureVersion;

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
     * SenderWebhook::with(active: ..., events: ..., signatureVersion: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderWebhook)
     *   ->withActive(...)
     *   ->withEvents(...)
     *   ->withSignatureVersion(...)
     *   ->withURL(...)
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
     * @param SignatureVersion|value-of<SignatureVersion> $signatureVersion
     */
    public static function with(
        array $events,
        SignatureVersion|string $signatureVersion,
        string $url,
        bool $active = true,
        ?string $secret = null,
    ): self {
        $self = new self;

        $self['active'] = $active;
        $self['events'] = $events;
        $self['signatureVersion'] = $signatureVersion;
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
     * Which `X-Zavu-Signature` scheme this receiver is sent.
     *
     * - `v1`: `v1=HMAC_SHA256(secret, body)`. The scheme used before this was configurable. Existing webhooks stay on it until you move them.
     * - `v2`: `v2=HMAC_SHA256(secret, "{t}.{body}")`. The current scheme, and the default for new senders. It signs the timestamp together with the body.
     * - `v1+v2`: both signatures, sharing one `t`. The migration setting: a receiver reading either one works, so you can deploy and confirm your new verifier before switching over.
     *
     * Moving from `v1` straight to `v2` returns `400`. Set `v1+v2` first. See https://docs.zavu.dev/guides/receiving-messages/signature-migration
     *
     * @param SignatureVersion|value-of<SignatureVersion> $signatureVersion
     */
    public function withSignatureVersion(
        SignatureVersion|string $signatureVersion
    ): self {
        $self = clone $this;
        $self['signatureVersion'] = $signatureVersion;

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
