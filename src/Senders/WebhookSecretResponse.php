<?php

declare(strict_types=1);

namespace Zavudev\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebhookSecretResponseShape = array{secret: string}
 */
final class WebhookSecretResponse implements BaseModel
{
    /** @use SdkModel<WebhookSecretResponseShape> */
    use SdkModel;

    /**
     * The new webhook secret.
     */
    #[Required]
    public string $secret;

    /**
     * `new WebhookSecretResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookSecretResponse::with(secret: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookSecretResponse)->withSecret(...)
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
     */
    public static function with(string $secret): self
    {
        $self = new self;

        $self['secret'] = $secret;

        return $self;
    }

    /**
     * The new webhook secret.
     */
    public function withSecret(string $secret): self
    {
        $self = clone $this;
        $self['secret'] = $secret;

        return $self;
    }
}
