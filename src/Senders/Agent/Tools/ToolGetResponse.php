<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AgentToolShape from \Zavudev\Senders\Agent\Tools\AgentTool
 *
 * @phpstan-type ToolGetResponseShape = array{tool: AgentTool|AgentToolShape}
 */
final class ToolGetResponse implements BaseModel
{
    /** @use SdkModel<ToolGetResponseShape> */
    use SdkModel;

    #[Required]
    public AgentTool $tool;

    /**
     * `new ToolGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolGetResponse::with(tool: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolGetResponse)->withTool(...)
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
     * @param AgentTool|AgentToolShape $tool
     */
    public static function with(AgentTool|array $tool): self
    {
        $self = new self;

        $self['tool'] = $tool;

        return $self;
    }

    /**
     * @param AgentTool|AgentToolShape $tool
     */
    public function withTool(AgentTool|array $tool): self
    {
        $self = clone $this;
        $self['tool'] = $tool;

        return $self;
    }
}
