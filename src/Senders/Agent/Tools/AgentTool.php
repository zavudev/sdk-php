<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ToolParametersShape from \Zavudev\Senders\Agent\Tools\ToolParameters
 *
 * @phpstan-type AgentToolShape = array{
 *   id: string,
 *   agentID: string,
 *   createdAt: \DateTimeInterface,
 *   description: string,
 *   enabled: bool,
 *   name: string,
 *   parameters: ToolParameters|ToolParametersShape,
 *   updatedAt: \DateTimeInterface,
 *   webhookURL: string,
 * }
 */
final class AgentTool implements BaseModel
{
    /** @use SdkModel<AgentToolShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('agentId')]
    public string $agentID;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Description for the LLM to understand when to use this tool.
     */
    #[Required]
    public string $description;

    #[Required]
    public bool $enabled;

    #[Required]
    public string $name;

    #[Required]
    public ToolParameters $parameters;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * HTTPS URL to call when the tool is executed.
     */
    #[Required('webhookUrl')]
    public string $webhookURL;

    /**
     * `new AgentTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentTool::with(
     *   id: ...,
     *   agentID: ...,
     *   createdAt: ...,
     *   description: ...,
     *   enabled: ...,
     *   name: ...,
     *   parameters: ...,
     *   updatedAt: ...,
     *   webhookURL: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentTool)
     *   ->withID(...)
     *   ->withAgentID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withEnabled(...)
     *   ->withName(...)
     *   ->withParameters(...)
     *   ->withUpdatedAt(...)
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
     * @param ToolParameters|ToolParametersShape $parameters
     */
    public static function with(
        string $id,
        string $agentID,
        \DateTimeInterface $createdAt,
        string $description,
        bool $enabled,
        string $name,
        ToolParameters|array $parameters,
        \DateTimeInterface $updatedAt,
        string $webhookURL,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentID'] = $agentID;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['enabled'] = $enabled;
        $self['name'] = $name;
        $self['parameters'] = $parameters;
        $self['updatedAt'] = $updatedAt;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Description for the LLM to understand when to use this tool.
     */
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
     * @param ToolParameters|ToolParametersShape $parameters
     */
    public function withParameters(ToolParameters|array $parameters): self
    {
        $self = clone $this;
        $self['parameters'] = $parameters;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * HTTPS URL to call when the tool is executed.
     */
    public function withWebhookURL(string $webhookURL): self
    {
        $self = clone $this;
        $self['webhookURL'] = $webhookURL;

        return $self;
    }
}
