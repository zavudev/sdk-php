<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters;

/**
 * Update a tool.
 *
 * @see Zavudev\Services\Senders\Agent\ToolsService::update()
 *
 * @phpstan-import-type ParametersShape from \Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters
 *
 * @phpstan-type ToolUpdateParamsShape = array{
 *   senderID: string,
 *   description?: string|null,
 *   enabled?: bool|null,
 *   name?: string|null,
 *   parameters?: null|Parameters|ParametersShape,
 *   webhookSecret?: string|null,
 *   webhookURL?: string|null,
 * }
 */
final class ToolUpdateParams implements BaseModel
{
    /** @use SdkModel<ToolUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?bool $enabled;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?Parameters $parameters;

    #[Optional(nullable: true)]
    public ?string $webhookSecret;

    #[Optional('webhookUrl')]
    public ?string $webhookURL;

    /**
     * `new ToolUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolUpdateParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolUpdateParams)->withSenderID(...)
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
     * @param Parameters|ParametersShape|null $parameters
     */
    public static function with(
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        Parameters|array|null $parameters = null,
        ?string $webhookSecret = null,
        ?string $webhookURL = null,
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $description && $self['description'] = $description;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $name && $self['name'] = $name;
        null !== $parameters && $self['parameters'] = $parameters;
        null !== $webhookSecret && $self['webhookSecret'] = $webhookSecret;
        null !== $webhookURL && $self['webhookURL'] = $webhookURL;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param Parameters|ParametersShape $parameters
     */
    public function withParameters(Parameters|array $parameters): self
    {
        $self = clone $this;
        $self['parameters'] = $parameters;

        return $self;
    }

    public function withWebhookSecret(?string $webhookSecret): self
    {
        $self = clone $this;
        $self['webhookSecret'] = $webhookSecret;

        return $self;
    }

    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
