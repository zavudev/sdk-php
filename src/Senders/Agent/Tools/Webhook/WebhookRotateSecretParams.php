<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools\Webhook;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Generate a new signing secret for this tool. The previous one stops working on the next call, with no overlap, so update your endpoint first. The tool keeps its id, so flows that reference it by name are unaffected.
 *
 * @see Zavudev\Services\Senders\Agent\Tools\WebhookService::rotateSecret()
 *
 * @phpstan-type WebhookRotateSecretParamsShape = array{senderID: string}
 */
final class WebhookRotateSecretParams implements BaseModel
{
    /** @use SdkModel<WebhookRotateSecretParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    /**
     * `new WebhookRotateSecretParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookRotateSecretParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookRotateSecretParams)->withSenderID(...)
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
    public static function with(string $senderID): self
    {
        $self = new self;

        $self['senderID'] = $senderID;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
