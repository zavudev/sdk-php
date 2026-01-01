<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters;

/**
 * Create a new tool for an agent. Tools allow the agent to call external webhooks.
 *
 * @see Zavudev\Services\Senders\Agent\ToolsService::create()
 *
 * @phpstan-import-type ParametersShape from \Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters
 *
 * @phpstan-type ToolCreateParamsShape = array{
 *   description: string,
 *   name: string,
 *   parameters: Parameters|ParametersShape,
 *   webhookURL: string,
 *   enabled?: bool|null,
 *   webhookSecret?: string|null,
 * }
 */
final class ToolCreateParams implements BaseModel
{
    /** @use SdkModel<ToolCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $description;

    #[Required]
    public string $name;

    #[Required]
    public Parameters $parameters;

    /**
     * Must be HTTPS.
     */
    #[Required('webhookUrl')]
    public string $webhookURL;

    #[Optional]
    public ?bool $enabled;

    /**
     * Optional secret for webhook signature verification.
     */
    #[Optional]
    public ?string $webhookSecret;

    /**
     * `new ToolCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolCreateParams::with(
     *   description: ..., name: ..., parameters: ..., webhookURL: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolCreateParams)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withParameters(...)
     *   ->withWebhookURL(...)
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
     * @param Parameters|ParametersShape $parameters
     */
    public static function with(
        string $description,
        string $name,
        Parameters|array $parameters,
        string $webhookURL,
        ?bool $enabled = null,
        ?string $webhookSecret = null,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['name'] = $name;
        $self['parameters'] = $parameters;
        $self['webhookURL'] = $webhookURL;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $webhookSecret && $self['webhookSecret'] = $webhookSecret;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

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

    /**
     * Must be HTTPS.
     */
    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Optional secret for webhook signature verification.
     */
    public function withWebhookSecret(string $webhookSecret): self
    {
        $self = clone $this;
        $self['webhookSecret'] = $webhookSecret;

        return $self;
    }
}
